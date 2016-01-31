<?php

namespace Map2u\CoreBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\Request;

class MapAdminController extends CRUDController {

    /**
     * Create action.
     *
     * @param Request $request
     *
     * @return Response
     *
     * @throws AccessDeniedException If access is not granted
     */
    public function createAction(Request $request = null) {
     //   $request = $this->resolveRequest($request);
        // the key used to lookup the template
        $templateKey = 'edit';

        $this->admin->checkAccess('create');

        $class = new \ReflectionClass($this->admin->hasActiveSubClass() ? $this->admin->getActiveSubClass() : $this->admin->getClass());

        if ($class->isAbstract()) {
            return $this->render(
                            'SonataAdminBundle:CRUD:select_subclass.html.twig', array(
                        'base_template' => $this->getBaseTemplate(),
                        'admin' => $this->admin,
                        'action' => 'create',
                            ), null, $request
            );
        }

        $object = $this->admin->getNewInstance();

        $preResponse = $this->preCreate($request, $object);
        if ($preResponse !== null) {
            return $preResponse;
        }

        $this->admin->setSubject($object);

        /** @var $form \Symfony\Component\Form\Form */
        $form = $this->admin->getForm();
        $form->setData($object);
        $form->handleRequest($request);
 var_dump(count($object->getLayers()));
        if ($form->isSubmitted()) {
            //TODO: remove this check for 3.0
            if (method_exists($this->admin, 'preValidate')) {
                $this->admin->preValidate($object);
            }
            $isFormValid = $form->isValid();

            // persist if the form was valid and if in preview mode the preview was approved
            if ($isFormValid && (!$this->isInPreviewMode($request) || $this->isPreviewApproved($request))) {
                $this->admin->checkAccess('create', $object);

                try {
                      
                    $object = $this->admin->create($object);

                    if ($this->isXmlHttpRequest($request)) {
                        return $this->renderJson(array(
                                    'result' => 'ok',
                                    'objectId' => $this->admin->getNormalizedIdentifier($object),
                                        ), 200, array(), $request);
                    }

                    $this->addFlash(
                            'sonata_flash_success', $this->admin->trans(
                                    'flash_create_success', array('%name%' => $this->escapeHtml($this->admin->toString($object))), 'SonataAdminBundle'
                            )
                    );

                    // redirect to edit mode
                    return $this->redirectTo($object, $request);
                } catch (ModelManagerException $e) {
                    $this->handleModelManagerException($e);

                    $isFormValid = false;
                }
            }

            // show an error message if the form failed validation
            if (!$isFormValid) {
                if (!$this->isXmlHttpRequest($request)) {
                    $this->addFlash(
                            'sonata_flash_error', $this->admin->trans(
                                    'flash_create_error', array('%name%' => $this->escapeHtml($this->admin->toString($object))), 'SonataAdminBundle'
                            )
                    );
                }
            } elseif ($this->isPreviewRequested($request)) {
                // pick the preview template if the form was valid and preview was requested
                $templateKey = 'preview';
                $this->admin->getShow();
            }
        }

        $view = $form->createView();

        // set the theme for the current Admin Form
        $this->get('twig')->getExtension('form')->renderer->setTheme($view, $this->admin->getFormTheme());

        return $this->render($this->admin->getTemplate($templateKey), array(
                    'action' => 'create',
                    'form' => $view,
                    'object' => $object,
                        ), null, $request);
    }

    /**
     * Edit action.
     *
     * @param int|string|null $id
     * @param Request         $request
     *
     * @return Response|RedirectResponse
     *
     * @throws NotFoundHttpException If the object does not exist
     * @throws AccessDeniedException If access is not granted
     */
    public function editAction($id = null, Request $request = null) {
        //  $request = $this->resolveRequest($request);
        // the key used to lookup the template
        $templateKey = 'edit';
 

        $id = $request->get($this->admin->getIdParameter());
       
        $object = $this->admin->getObject($id);

        if (!$object) {
            throw $this->createNotFoundException(sprintf('unable to find the object with id : %s', $id));
        }

        $this->admin->checkAccess('edit', $object);
 
        $preResponse = $this->preEdit($request, $object);
        if ($preResponse !== null) {
            return $preResponse;
        }

        $this->admin->setSubject($object);

        /** @var $form Form */
        $form = $this->admin->getForm();
    
        $form->setData($object);
    
        $form->handleRequest($request);
      



        if ($form->isSubmitted()) {
            
           
            
            //TODO: remove this check for 3.0
            if (method_exists($this->admin, 'preValidate')) {
                $this->admin->preValidate($object);
            }
            $isFormValid = $form->isValid();

            // persist if the form was valid and if in preview mode the preview was approved
            if ($isFormValid && (!$this->isInPreviewMode($request) || $this->isPreviewApproved($request))) {
                try {

                   
                    $object = $this->admin->update($object);

                    if ($this->isXmlHttpRequest($request)) {
                        return $this->renderJson(array(
                                    'result' => 'ok',
                                    'objectId' => $this->admin->getNormalizedIdentifier($object),
                                    'objectName' => $this->escapeHtml($this->admin->toString($object)),
                                        ), 200, array(), $request);
                    }

                    $this->addFlash(
                            'sonata_flash_success', $this->admin->trans(
                                    'flash_edit_success', array('%name%' => $this->escapeHtml($this->admin->toString($object))), 'SonataAdminBundle'
                            )
                    );

                    // redirect to edit mode
                    return $this->redirectTo($object, $request);
                } catch (ModelManagerException $e) {
                    $this->handleModelManagerException($e);

                    $isFormValid = false;
                } catch (LockException $e) {
                    $this->addFlash('sonata_flash_error', $this->admin->trans('flash_lock_error', array(
                                '%name%' => $this->escapeHtml($this->admin->toString($object)),
                                '%link_start%' => '<a href="' . $this->admin->generateObjectUrl('edit', $object) . '">',
                                '%link_end%' => '</a>',
                                    ), 'SonataAdminBundle'));
                }
            }

            // show an error message if the form failed validation
            if (!$isFormValid) {
                if (!$this->isXmlHttpRequest($request)) {
                    $this->addFlash(
                            'sonata_flash_error', $this->admin->trans(
                                    'flash_edit_error', array('%name%' => $this->escapeHtml($this->admin->toString($object))), 'SonataAdminBundle'
                            )
                    );
                }
            } elseif ($this->isPreviewRequested($request)) {
                // enable the preview template if the form was valid and preview was requested
                $templateKey = 'preview';
                $this->admin->getShow();
            }
        }

        $view = $form->createView();

        // set the theme for the current Admin Form
        $this->get('twig')->getExtension('form')->renderer->setTheme($view, $this->admin->getFormTheme());

        return $this->render($this->admin->getTemplate($templateKey), array(
                    'action' => 'edit',
                    'form' => $view,
                    'object' => $object,
                        ), null, $request);
    }

}
