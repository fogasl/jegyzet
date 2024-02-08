<?php

namespace FLDSoftware\WebApp\Http;

use FLDSoftware\Http\ResponseHandler;
use FLDSoftware\WebApp\WebApplicationBase;
use Smarty;

class SmartyResponseHandler extends ResponseHandler {

    protected function setupSmarty($smartyConfig) {
        $this->smarty = new Smarty();

        $this->smarty->setTemplateDir(
            $smartyConfig["templateDir"]
        );

        $this->smarty->setCompileDir(
            $smartyConfig["compileDir"]
        );

        $this->smarty->setConfigDir(
            $smartyConfig["configDir"]
        );

        $this->smarty->setCacheDir(
            $smartyConfig["cacheDir"]
        );

        $this->smarty->caching = Smarty::CACHING_LIFETIME_CURRENT;
    }

    protected $smarty;

    public function __construct(WebApplicationBase $context = null) {
        parent::__construct($context);

        $this->setupSmarty($context->config->getValue("smarty"));
    }

    public function smarty(string $template, $data) {
        // FIXME: these should come from `View` instances!
        $this->smarty->assign("appData", $this->context->appData);
        $this->smarty->assign("appConfig", $this->context->config);

        $this->smarty->assign("data", $data);

        // Render template
        $content = $this->smarty->fetch($template);

        // Set as response body
        $this->response->setBody(
            $content
        );

        $this->response->setHeader(
            "Content-Type",
            "text/html"
        );

        return $this;
    }

}
