<?php

class Pages extends Controller {

    private $pagesModel;

    public function __construct() {
        $this->pagesModel = $this->model('Page');
    }

    public function index() {


        $data = [
            'pages' => $this->pagesModel->getPagesTitle(),
            'title' => 'SharePosts',
            'description' => 'Simple social network built on the TraversyMVC PHP framework'
        ];

        $this->view('pages/index', $data);
    }

    public function show($id = '') {
        empty($id) ? redirect('pages', TRUE) : NULL;
        $data = [
            'pages' => $this->pagesModel->getPagesTitle(),
            'page' => $this->pagesModel->getPageById($id)
        ];

        $this->view('pages/show', $data);
    }

}
