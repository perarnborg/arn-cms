<?php

class ArnstructreController extends ControllerBase
{
    public function initialize()
    {        
    }

    public function indexAction()
    {
    }

    public function contenttypesAction()
    {
        $contentTypes = ArnContentType::find();
        $this->view->contentTypes = $contentTypes;
    }

    public function contenttypeAction($id = null)
    {
        $contentType = new ArnContentType();
        $fields = array();
        if($id) {
            $contentType = ArnContentType::findFirst((int)$id);
            $fields = $contentType::getField();
        }
        $this->view->contentType = $contentType;
    }

    public function taxonomiesAction()
    {
        $taxonomies = ArnTaxonomy::find();
        $this->view->taxonomies = $taxonomies;
    }

    public function taxonomyAction($id = null)
    {
        $taxonomy = new ArnTaxonomy();
        if($id) {
            $taxonomy = ArnTaxonomy::findFirst((int)$id);
        }        
        $this->view->taxonomy = $taxonomy;
    }
}
