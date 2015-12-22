<?php

// src/Map2u/WebgisBundle/Twig/Map2uExtension.php

namespace Map2u\CoreBundle\Twig;

class Map2uExtension extends \Twig_Extension
{

  public function getFilters()
  {
    return array(
      'imgpath' => new \Twig_Filter_Method($this, 'imgpathFilter'),
      'bcmod' => new \Twig_Filter_Method($this, 'bcmodFilter'),
      'price' => new \Twig_Filter_Method($this, 'priceFilter'),
      'resultToHtml' => new \Twig_Filter_Method($this, 'resultToHtmlFilter'),
      'unserialize' => new \Twig_Filter_Method($this, 'unserializeFilter'),
    );
  }

  public function priceFilter($number, $decimals = 0, $decPoint = '.', $thousandsSep = ',')
  {
    $price = number_format($number, $decimals, $decPoint, $thousandsSep);
    $price = '$' . $price;

    return $price;
  }

  public function unserializeFilter($serial)
  {
    return unserialize($serial);
  }

  public function bcmodFilter($number, $mod)
  {
    $pathnumber = strval($number);
    return bcmod($pathnumber, $mod);
  }

  public function imgpathFilter($number)
  {
    $pathnumber = strval($number);
    $imgpath = '';
    for ($i = 0; $i < strlen($pathnumber); $i++)
    {
      if ($i == 0) {
        $imgpath = $pathnumber[$i];
      } else {
        $imgpath = $imgpath . '/' . $pathnumber[$i];
      }
    }
    //  $imgpath = $imgpath.'-'. $type.'.jpg';

    return $imgpath;
  }

  public function resultToHtmlFilter($result)
  {
    $htmlOptions = array('class' => "set_position", 'data' => array());
    if (isset($result['type']) && isset($result['id']))
    {
      //$url = url_for(:controller => :browse, :action => result[:type], :id => result[:id])
    }



    foreach ($result as $key => $value)
    {
      $htmlOptions['data'][str_replace('_', '-', $key)] = $value;
    }
    //  var_dump($html_options);
    $html = "";
//    if (isset($result['prefix']))
//    {
//      $html .= $result['prefix'];
//    }
//    if (isset($result['prefix']) && isset($result['name']))
//    {
//      $html .= " ";
//    }
    if (isset($result['name']))
    {
      $html .= "<a ";
      $html .= 'class="' . $htmlOptions['class'] . '"';
  //    $html .= ' href="' . $url . '"';
//      foreach ($htmlOptions['data'] as $key => $value)
//      {
//        $html .= ' data-' . $key . '="' . $value . '"';
//      }
      $html .= ">" . $result['name'] . "</a>";
    }
    if (isset($result['suffix']))
    {
      $html .= $result['suffix'];
    }
    return $html;
  }

  public function getName()
  {
    return 'map2u_extension';
  }

}
