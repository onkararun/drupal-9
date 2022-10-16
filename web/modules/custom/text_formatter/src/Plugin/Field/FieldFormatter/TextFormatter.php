<?php

namespace Drupal\text_formatter\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;

/**
 * Plugin implementation of the 'text' formatter.
 *
 * @FieldFormatter(
 *   id = "text_heading",
 *   label = @Translation("h2 Heading"),
 *   field_types = {
 *     "text"
 *   }
 * )
 */

class TextFormatter extends FormatterBase { 
    /**
     * {@inheritdoc}
     */
    
    public function viewElements(FieldItemListInterface $items, $langcode){
    	$elements = array();
    	foreach($items as $key => $item){
    		$text = $item->value;
    		$elements[$key] = array(
    			'#type'=>'markup',
    			'#markup'=>'<h2>'.$text.'</h2>',
    		);
    	}
    	return $elements;	
    } 
}
