<?php

namespace app;

class Handle {
    private $request;
    private $response;
    private $imageEntity;

    public function __construct($request, $response) {
        $this->request = $request;
        $this->response = $response;
    }

    public function getRequest() {
        return $this->request;
    }

    public function getResponse() {
        return $this->response;
    }

    public function getInfo(): array {
        $src = $this->getRequest()->get['src'];
        $w = $this->getRequest()->get['w'];
        $h = $this->getRequest()->get['h'];
        return ['src' => $src, 'w' => $w, 'h' => $h];
    }

    public function image() {
        if (empty($this->getInfo()['src'])) {
            $this->response->header('Content-Type', 'application/json');
            $this->response->end(json_encode(['code' => 101, 'msg' => '错误的提交']));
            return;
        }
        $this->getImageEntity()->setConfig($this->getInfo());
        $file = $this->getImageEntity()->getPicByKey();
        $this->response->header('Content-Type', 'image/jpeg');
        $this->response->sendfile($file);
    }

    public function getImageEntity(): ImageEntity {
        if (empty($this->imageEntity)) {
            $this->imageEntity = new ImageEntity();
        }
        return $this->imageEntity;
    }
}
