<?php 
namespace Drupal\node_unpublish\Controller;
use Drupal\Core\Controller\ControllerBase;
use Drupal\node\Entity\Node;

Class NodeunpublishController extends ControllerBase{
	public function deleteNode() {
	    $deleteNode = 134;
	    $deletedArticleNode = $this->deleteArticleNode($deleteNode);
	    $element = [
	         '#markup' => '<p>' . t('Unpublished article node id. ') . $deleteNode.'</p>',
	    ];
	    return $element;
	}
	protected function deleteArticleNode($deleteNode){
		$node = Node::load($deleteNode);
		$node->status = 0;
        $node->save();
		return true;
	}
} 



