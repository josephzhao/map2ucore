<?php

namespace Map2u\CoreBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Map2u\CoreBundle\Classes\Map2uPDF;
use Application\Map2u\CoreBundle\Form\Type\UserprofileType;
use Application\Map2u\CoreBundle\Form\Type\UserSecurityType;

/**
 * Default controller.
 *
 * @Route("/account")
 */
class UserAccountController extends Controller {

    /**
     * Displays  page header.
     *
     * @Route("/", name="useraccount_index", options={"expose"=true})
     * @Method("GET|POST")
     * @Template()
     */
    public function indexAction() {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();

        $request = $this->get('request');
        $conn = $this->get('database_connection');
        $form = $this->get('form.factory')->create(new UserprofileType($conn), $user);
        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);
            if ($form->isValid()) {
                $em->persist($user);
                $em->flush();
                $this->get('session')->setFlash('notice', 'You have successfully added '
                        . $user->getFirstname() . ' ' . $user->getLastname() . ' to the database!');
//return $this->redirect($this->generateUrl('walkthrough_add_user'));
            }
        }
        $states = $em->getRepository("Map2uCoreBundle:State")->findAll();
        return array('user' => $this->getUser(), 'form' => $form->createView(), 'states' => $states);
    }

    /**
     * Displays upload polygon page header.
     *
     * @Route("/showpersonalinfo", name="useraccount_showpersonalinfo", options={"expose"=true})
     * @Method("GET")
     * @Template()
     */
    public function showpersonalinfoAction(Request $request) {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $conn = $this->get('database_connection');
        $upgradeEntities = null;
        $membership = null;
        $form = $this->get('form.factory')->create(new UserprofileType($conn));
        if ($user) {
//            $upgradeEntities = $em->getRepository("Map2uManifoldMapsBundle:ManifoldMembershipUpgrade")->findBy(array('userId' => $user->getId(), 'payed' => false));
//            if ($upgradeEntities) {
//                foreach ($upgradeEntities as $upgradeEntity) {
//                    $membership = $em->getRepository("Map2uManifoldMapsBundle:ManifoldMembership")->find($upgradeEntity->getRequestMembershipId());
//                    $upgradeEntity->membership = $membership;
//                    var_dump($upgradeEntity->membership->getPrice());
//                }
//            }
        }

        return array('user' => $user, 'upgradeEntities' => $upgradeEntities, 'form' => $form->createView());
    }

    /**
     * Displays upload polygon page header.
     *
     * @Route("/updatepersonalinfo", name="useraccount_updatepersonalinfo", options={"expose"=true})
     * @Method("GET|POST")
     * @Template()
     */
    public function updatepersonalinfoAction(Request $request) {
        $user = $this->getUser();

        $conn = $this->get('database_connection');
        $form = $this->get('form.factory')->create(new UserprofileType($conn), $user);
        if ($request->getMethod() == 'POST') {
            $form->bind($request);
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();
                $this->get('session')->getFlashBag()->add('notice', 'You have successfully added '
                        . $user->getFirstname() . ' ' . $user->getLastname() . ' to the database!');
                if (true === $request->isXmlHttpRequest()) {
                    return new JsonResponse(array('success' => true, 'message' => 'You have successfully updated user info!', 'status' => 'ok'));
                }
//return $this->redirect($this->generateUrl('walkthrough_add_user'));
            }
        }

        $states = array();
        if (isset($conn) && $conn != null) {

            $sql = "select * from tab_states";
            $states = $conn->fetchAll($sql);
        }

        return array('user' => $this->getUser(), 'form' => $form->createView(), 'states' => $states);
    }

    /**
     * Displays upload polygon page header.
     *
     * @Route("/updatesecurity", name="useraccount_updatesecurity", options={"expose"=true})
     * @Method("GET|POST")
     * @Template()
     */
    public function updatesecurityAction(Request $request) {
        $user = $this->getUser();
        $request = $this->get('request');
        $conn = $this->get('database_connection');
        $form = $this->get('form.factory')->create(new UserSecurityType($conn), $user);
        if ($request->getMethod() == 'POST') {
            $form->bind($request);
            if ($form->isValid()) {
                $encoder_service = $this->get('security.encoder_factory');
                $currentPassword = $form['currentPassword']->getData();
                $encoder = $encoder_service->getEncoder($user);
                if ($encoder->isPasswordValid($user->getPassword(), $currentPassword, $user->getSalt())) {
                    $em = $this->getDoctrine()->getManager();
                    $plainPassword = $form['plainPassword']->getData();
                    $confirmationPassword = $form['confirmationPassword']->getData();
                    if ($plainPassword === $confirmationPassword) {
                        $user->setPlainPassword($plainPassword);
                        $em->persist($user);
                        $em->flush();
                        $this->get('session')->getFlashBag()->add('notice', 'You have successfully updated password!');
                        if (true === $request->isXmlHttpRequest()) {
                            return new JsonResponse(array('success' => true, 'message' => 'You have successfully updated user info!', 'status' => 'ok'));
                        }
                    } else {
                        return new JsonResponse(array('success' => false, 'message' => "Your new password doesn't match password condirmation!", 'status' => 'ok'));
                    }
                } else {
                    return new JsonResponse(array('success' => false, 'message' => 'Your current password is wrong!', 'status' => 'ok'));
                }

//return $this->redirect($this->generateUrl('walkthrough_add_user'));
            }
        }



        return array('user' => $this->getUser(), 'form' => $form->createView());
    }

    /**
     * Displays upload polygon page header.
     *
     * @Route("/showmembership", name="useraccount_showmembership", options={"expose"=true})
     * @Method("GET")
     * @Template()
     */
    public function showmembershipAction(Request $request) {
        $user = $this->getUser();
        $conn = $this->get('database_connection');
        $form = $this->get('form.factory')->create(new UserMembershipType($conn), $user);
        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();
                $this->get('session')->setFlash('notice', 'You have successfully added ');

//        . $user->getFirstname() . ' ' . $user->getLastname() . ' to the database!');
//return $this->redirect($this->generateUrl('walkthrough_add_user'));
            }
        }
        return array('user' => $user, 'form' => $form->createView());
    }

    /**
     * Displays upload polygon page header.
     *
     * @Route("/upgrademembership", name="useraccount_upgrademembership", options={"expose"=true})
     * @Method("GET|POST")
     * @Template()
     */
    public function upgrademembershipAction(Request $request) {
        $user = $this->getUser();
        $conn = $this->get('database_connection');

        $form = $this->get('form.factory')->create(new UserMembershipType($conn));
        if ($request->getMethod() == 'POST' && $user) {

            $form->bind($request);

            if ($form->isValid()) {
                $sessionid = $request->getSession()->getId();
                $em = $this->getDoctrine()->getManager();
                $upgradeEntity = $em->getRepository("Map2uManifoldMapsBundle:ManifoldMembershipUpgrade")->findOneBy(array('userId' => $user->getId(), 'sessionid' => $sessionid));
                $membership_data = $form['membership']->getData();
                $addonmodules_data = $form['addonmodules']->getData();
                $bbmmodules_data = $form['bbmmodules']->getData();
                $totalCost = $request->get("totalcost");
                if ($upgradeEntity == null) {
                    $upgradeEntity = new ManifoldMembershipUpgrade();
                    $upgradeEntity->setUser($user);
                    $upgradeEntity->setSessionid($sessionid);
                    foreach ($addonmodules_data as $addonmodule_data) {
                        $upgradeEntity->addAddonmodule($addonmodule_data);
                        $addonmodule_data->addMembershipupgrade($upgradeEntity);
                        $em->persist($addonmodule_data);
                    }
                    foreach ($bbmmodules_data as $bbmmodule_data) {
                        $upgradeEntity->addBbmmodule($bbmmodule_data);
                        $bbmmodule_data->addMembershipupgrade($upgradeEntity);
                        $em->persist($bbmmodule_data);
                    }
                    if ($user->getMembership()) {
                        $upgradeEntity->setCurrentMembershipId($user->getMembership()->getId());
                    } else {
                        $upgradeEntity->setCurrentMembershipId(1);
                    }
                    $upgradeEntity->setRequestMembershipId($membership_data->getId());
                }
                $upgradeEntity->setTotalCost($totalCost);
                $em->persist($upgradeEntity);
                $em->flush();
                $sql = "select sum(amount) as amount from manifold_billings where user_uuid=" . $user->getId() . " limit 1";
                $billings = $conn->fetchAll($sql);
                $sql = "select sum(charge_total) as amount from manifold_payments where user_uuid=" . $user->getId() . " limit 1";
                $payments = $conn->fetchAll($sql);

                $balance = floatval($billings[0]['amount']) - floatval($payments[0]['amount']);

                return new JsonResponse(array("success" => true, 'rvar_billtype' => 'membership upgrade', 'rvar_transid' => $upgradeEntity->getId(), "message" => "User not logged in"));
                // return $this->render('Map2uManifoldMapsBundle:UserAccount:upgradecheckout.html.twig', array('form' => $form->createView(), 'balance' => $balance, 'totalCost' => $totalCost, 'upgradeentity' => $upgradeEntity, "membership_data" => $membership_data, "addonmodules_data" => $addonmodules_data, "bbmmodules_data" => $bbmmodules_data));
            }
        } else {
            return new JsonResponse(array("success" => false, "message" => "User not logged in"));
        }
    }

    /**
     * Displays upload polygon page header.
     *
     * @Route("/upgradecheckout", name="useraccount_upgradecheckout", options={"expose"=true})
     * @Method("GET|POST")
     * @Template()
     */
    public function upgradecheckoutAction(Request $request) {
        
    }

    /**
     * Displays upload polygon page header.
     *
     * @Route("/upgrademembership_delete", name="useraccount_upgrademembership_delete", options={"expose"=true})
     * @Method("POST")
     * @Template()
     */
    public function upgrademembership_deleteAction(Request $request) {
        $id = $request->get("id");

        $user = $this->getUser();
        if ($user) {
            $em = $this->getDoctrine()->getManager();
            $upgradeEntity = $em->getRepository("Map2uManifoldMapsBundle:ManifoldMembershipUpgrade")->findOneBy(array('userId' => $user->getId(), 'id' => $id));
            if ($upgradeEntity) {
                $em->remove($upgradeEntity);
                $em->flush();

                return new JsonResponse(array('success' => true, 'message' => 'membership upgrade info successfully removed!', 'status' => 'ok'));
            } else {
                return new JsonResponse(array('success' => false, 'message' => 'membership upgrade info not found!' . $user->getId() . ' : ' . $id, 'status' => 'ok'));
            }
        }
        return new JsonResponse(array('success' => false, 'message' => 'membership upgrade info not able to remove!', 'status' => 'ok'));
    }

    /**
     * Displays upload polygon page header.
     *
     * @Route("/updatemembership", name="useraccount_updatemembership", options={"expose"=true})
     * @Method("GET|POST")
     * @Template()
     */
    public function updatemembershipAction(Request $request) {
        $user = $this->getUser();

        $conn = $this->get('database_connection');

        $em = $this->getDoctrine()->getManager();
        $memberships = $em->getRepository("Map2uManifoldMapsBundle:ManifoldMembership")->findAll();
        $addonmodules = $em->getRepository("Map2uManifoldMapsBundle:ManifoldAddonModule")->findAll();
        $bbmmodules = $em->getRepository("Map2uManifoldMapsBundle:ManifoldBBMModule")->findAll();


        $form = $this->get('form.factory')->create(new UserMembershipType($conn));
        if ($request->getMethod() == 'POST') {


            $form->bind($request);

            if ($form->isValid()) {

                $membership_data = $form['membership']->getData();
                $addonmodules_data = $form['addonmodules']->getData();
                $bbmmodules_data = $form['bbmmodules']->getData();

                return $this->render('Map2uManifoldMapsBundle:UserAccount:membershipconfirm.html.twig', array('form' => $form->createView(), "membership" => $membership_data, "membership_data" => $membership_data, "addonmodules" => $addonmodules_data, "addonmodules_data" => $addonmodules_data, "bbmmodules" => $bbmmodules_data, "bbmmodules_data" => $bbmmodules_data));
            } else {
                if (true === $request->isXmlHttpRequest()) {
                    return new JsonResponse(array('success' => false, 'message' => 'Sorry, something wrong and membership upgrade failed!', 'status' => 'ok'));
                }
            }
        } else {
            $membership_data = $request->get('membership');
            $addonmodules_data = $request->get('addonmodules');
            $bbmmodules_data = $request->get('bbmmodules');
        }
        return array("memberships" => $memberships, "addonmodules" => $addonmodules, "bbmmodules" => $bbmmodules, 'form' => $form->createView(), "membership_data" => $membership_data, "addonmodules_data" => $addonmodules_data, "bbmmodules_data" => $bbmmodules_data);
//    return array('user' => $this->getUser(),"membership"=>$membership);
    }

    /**
     * Displays upload polygon page header.
     *
     * @Route("/showcreditblance", name="useraccount_showcreditblance", options={"expose"=true})
     * @Method("GET")
     * @Template()
     */
    public function showcreditblanceAction(Request $request) {
        $user = $this->getUser();
        return array('user' => $user);
    }

    /**
     * Displays upload polygon page header.
     *
     * @Route("/showinvoice", name="useraccount_showinvoice", options={"expose"=true})
     * @Method("GET")
     * @Template()
     */
    public function showinvoiceAction(Request $request) {
        $user = $this->getUser();
        return array('user' => $user);
    }

    /**
     * Displays upload polygon page header.
     *
     * @Route("/showrecentactivity", name="useraccount_showrecentactivity", options={"expose"=true})
     * @Method("GET")
     * @Template()
     */
    public function showrecentactivityAction(Request $request) {
        $user = $this->getUser();
        return array('user' => $user);
    }

    /**
     * Displays upload polygon page header.
     *
     * @Route("/stransaction", name="useraccount_stransaction", options={"expose"=true})
     * @Method("GET|POST")
     * @Template()
     */
    public function stransactionAction(Request $request) {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $bank_transaction_id = $request->get("bank_transaction_id");
        $newpayment = $em->getRepository($persistentObjectName)->findOneBy(array($bank_transaction_id));
        if ($newpayment == null) {
            $newpayment = new UserPayment();
            $newpayment->setUser($user);
            $newpayment->setBankApprovalCode($request->get("bank_approval_code"));
            $newpayment->setCardholder($request->get("cardholder"));
            $newpayment->setIsVisaDebit($request->get("is_visa_debit"));
            $newpayment->setIsoCode($request->get("iso_code"));
            $newpayment->setBankTransactionId($request->get("bank_transaction_id"));
            $newpayment->setResponseOrderId($request->get("response_order_id"));
            $newpayment->setChargeTotal($request->get("charge_total"));
            $newpayment->setTransName($request->get("trans_name"));
            $newpayment->setRvarTransid($request->get("rvar_transid"));
            $newpayment->setRvarBilltype($request->get("rvar_billtype"));
            $newpayment->setF4l4($request->get("f4l4"));
            $newpayment->setCard($request->get("card"));
            $newpayment->setMessage($request->get("message"));
            $newpayment->setExpiryDate($request->get("expiry_date"));
            $newpayment->setResult($request->get("result"));
            $newpayment->setTxnNum($request->get("txn_num"));
            $newpayment->setTimeStamp($request->get("time_stamp"));
            $newpayment->setDateStamp($request->get("date_stamp"));
            $newpayment->setResponseCode($request->get("response_code"));
            $em->persist($newpayment);
            $em->flush();
            $this->createInvoice($newpayment);
        }
        return array('user' => $user, 'payment' => $newpayment);
    }

    /**
     * Displays upload polygon page header.
     *
     * @Route("/ftransaction", name="useraccount_ftransaction", options={"expose"=true})
     * @Method("GET|POST")
     * @Template()
     */
    public function ftransactionAction(Request $request) {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $newpayment = new UserPayment();
        $newpayment->setUser($user);
        $newpayment->setBankApprovalCode($request->get("bank_approval_code"));
        $newpayment->setCardholder($request->get("cardholder"));
        $newpayment->setIsVisaDebit($request->get("is_visa_debit"));
        $newpayment->setIsoCode($request->get("iso_code"));
        $newpayment->setBankTransactionId($request->get("bank_transaction_id"));
        $newpayment->setResponseOrderId($request->get("response_order_id"));
        $newpayment->setChargeTotal($request->get("charge_total"));
        $newpayment->setTransName($request->get("trans_name"));
        $newpayment->setRvarTransid($request->get("rvar_transid"));
        $newpayment->setRvarBilltype($request->get("rvar_billtype"));
        $newpayment->setF4l4($request->get("f4l4"));
        $newpayment->setCard($request->get("card"));
        $newpayment->setMessage($request->get("message"));
        $newpayment->setExpiryDate($request->get("expiry_date"));
        $newpayment->setResult($request->get("result"));
        $newpayment->setTxnNum($request->get("txn_num"));
        $newpayment->setTimeStamp($request->get("time_stamp"));
        $newpayment->setDateStamp($request->get("date_stamp"));
        $newpayment->setResponseCode($request->get("response_code"));
        $em->persist($newpayment);
        $em->flush();

        return array('user' => $user, 'payment' => $newpayment);
    }

    /**
     * Displays upload polygon page header.
     *
     * @Route("/ctransaction", name="useraccount_ctransaction", options={"expose"=true})
     * @Method("GET|POST")
     * @Template()
     */
    public function ctransactionAction(Request $request) {
        $user = $this->getUser();
        var_dump($request->get('xml_response'));
        return array('user' => $user);
    }

    private function createInvoice(\Map2u\Manifold\MapsBundle\Entity\UserPayment $payment) {
        if ($payment->getInvoice() === null) {
            $invoice = new ManifoldInvoice();
            $invoice->setUser($this->getUser());
            $invoice->setPayment($payment);
            $invoice->setAmount($payment->getChargeTotal());
            $payment->setInvoice($invoice);

            $this->createInvoicePdfFile($invoice);
        }
    }

    private function createInvoicePdfFile(\Map2u\Manifold\MapsBundle\Entity\ManifoldInvoice $invoice) {
        if ($this->getUser() === null) {
            return;
        }
        $pdfObj = new Map2uPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdfObj->AddPage();
        $pdfObj->Ln(10);
        $pdfObj->write(2, "1.0 Site Description");

//        // column titles
////    $pdfObj->Ln();
//        $max_width = 180;
//        $max_height = intval(floatval($max_width) * $rate);
//        $map_width = 640;
//        ;
//        $map_height = 640 * $size_array[1] / floatval($size_array[0]); //intval(floatval($map_width)*$rate);
//        $url = "http://maps.googleapis.com/maps/api/staticmap?center=" . $center . "&zoom=" . $level . "&size=" . $map_width . "x" . $map_height . "&sensor=false";
//
//        $mapdata = http_get($url);
//        echo $url . "<br>";
////    $mapdata = http_get("http://dev.virtualearth.net/REST/V1/Imagery/Map/Road/space%20needle,seattle?mapLayer=TrafficFlow&mapVersion=v1&key=AlkdEy1SbQunXXg1BzwEc91j47euCKkYw8r0_wu6OP24I9QL68Ywuk1eFWjB3LR0");
//        $body = http_parse_message($mapdata)->body;
//
//        $pdfObj->setImageScale(PDF_IMAGE_SCALE_RATIO);
//        $_filename1 = 'tmp/tmpfile' . microtime(true) . '.jpeg';
//        file_put_contents($_filename1, $body);
//        //   $pdfObj->Ln();
//        //  $pdfObj->Rect(15 + 55, 160, 52, 70);
//        list($width, $height) = getimagesize($_filename1);
//        $ratioh = $max_height / $height;
//        $ratiow = $max_width / $width;
//        $ratio = min($ratioh, $ratiow);
//// New dimensions
//        $width = intval($ratio * $width);
//        $height = intval($ratio * $height);
//
//        //  $pdfObj->Image($_filename, 15 + 55, 160, $width, $height);   
//
//        $mapdata = http_get("http://maps.superdemographics.com:8086/geoserver/manifold/wms?service=WMS&version=1.1.0&request=GetMap&layers=manifold:gcsd11a_ke2012_35&styles=&bbox=-82.11251,42.38515,-79.53149,44.24471&width=512&height=331&srs=EPSG:4326&transparent=true&format=image%2Fpng");
//        $body = http_parse_message($mapdata)->body;
//        $pdfObj->setImageScale(PDF_IMAGE_SCALE_RATIO);
//        $_filename2 = 'tmp/tmpfile' . microtime(true) . '.jpeg';
//        file_put_contents($_filename2, $body);
//        //   $pdfObj->Ln();
//        //  $pdfObj->Rect(15 + 55, 160, 52, 70);
//        list($width, $height) = getimagesize($_filename2);
//        $ratioh = $max_height / $height;
//        $ratiow = $max_width / $width;
//        $ratio = min($ratioh, $ratiow);
//// New dimensions
//        $width = intval($ratio * $width);
//        $height = intval($ratio * $height);
//
//        $img1 = new \Imagick($_filename1);
//        $img2 = new \Imagick($_filename2);
//
//        $img1->compositeImage($img2, \Imagick::COMPOSITE_OVER, 0, 0);
//
//        $_filename3 = 'tmp/tmpfile' . microtime(true) . '.jpeg';
//
//        $img1->setImageFileName($_filename3);
//
//        // Let's write the image. 
//        if (FALSE == $img1->writeImage()) {
//            throw new Exception();
//        }
//
//        $pdfObj->Image($_filename3, 15, 30, $width, $height);
//
//
//        // $this->getBingMap($pdfObj);
//        if (file_exists($_filename1)) {
//            unlink($_filename1);
//        }
//        if (file_exists($_filename2)) {
//            unlink($_filename2);
//        }
//        if (file_exists($_filename3)) {
//            unlink($_filename3);
//        }

        $datapath = $this->get('kernel')->getRootDir() . '/../Data/Invoices/' . $this->getUser()->getId() . "/";
        if (file_exists($datapath) == false) {
            shell_exec("mkdir -p " . $datapath);
        }
        $invoiceFileName = $datapath . $invoiceFileName->getId() . ".pdf";
        $invoice->setInvoiceFileName($invoiceFileName);
        $pdfObj->Output($invoiceFileName, 'I');
    }

}
