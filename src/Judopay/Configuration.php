<?php

namespace Judopay;

class Configuration
{
    protected $settings = array();

    protected $valid_config_keys = array(
        'apiVersion',
        'apiToken',
        'apiSecret',
        'oauthAccessToken',
        'format',
        'endpointUrl',
        'userAgent',
        'judoId',
        'useProduction',
        'logger',
        'httpLogFormat'
    );

    public function __construct($settings = null)
    {
        // Set sensible defaults
        $this->settings['apiVersion'] = '4.0.0';
        $this->settings['logger'] = new \Psr\Log\NullLogger();
        $this->settings['userAgent'] = 'Judopay PHP SDK v'.\Judopay::VERSION;
        $this->settings['httpLogFormat'] = "\"{method} {resource} {protocol}/{version}\" ".
                                           "{code} Content-Length: {res_header_Content-Length}\n| Response: {response}";

        // Override defaults with user settings
        $newSettings = $this->removeInvalidConfigKeys($settings);
        if (is_array($newSettings)) {
            $this->settings = array_replace($this->settings, $newSettings);
        }

        $this->setEndpointUrl();
    }

    public function isValidConfigKey($key)
    {
        return (in_array($key, $this->valid_config_keys));
    }

    public function get($key)
    {
        if (!array_key_exists($key, $this->settings)) {
            return null;
        }

        return $this->settings[$key];
    }

    public function getAll()
    {
        return $this->settings;
    }

    public function add($key, $value)
    {
        $this->settings[$key] = $value;

        return $this->settings[$key];
    }

    protected function removeInvalidConfigKeys($config)
    {
        if (!is_array($config)) {
            return false;
        }

        $output = array();

        foreach ($config as $key => $value) {
            if (in_array($key, $this->valid_config_keys)) {
                $output[$key] = $value;
            }
        }

        return $output;
    }

    protected function setEndpointUrl()
    {
        if (isset($this->settings['useProduction']) && $this->settings['useProduction'] === true) {
            $this->settings['endpointUrl'] = 'https://gw1.judopay.com';
        } else {
            $this->settings['endpointUrl'] = 'https://gw1.judopay-sandbox.com';
        }
    }
}
