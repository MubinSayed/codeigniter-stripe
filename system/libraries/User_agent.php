<?php
/**
 * CodeIgniter.
 *
 * An open source application development framework for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2014 - 2019, British Columbia Institute of Technology
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @author	EllisLab Dev Team
 * @copyright	Copyright (c) 2008 - 2014, EllisLab, Inc. (https://ellislab.com/)
 * @copyright	Copyright (c) 2014 - 2019, British Columbia Institute of Technology (https://bcit.ca/)
 * @license	https://opensource.org/licenses/MIT	MIT License
 *
 * @link	https://codeigniter.com
 * @since	Version 1.0.0
 * @filesource
 */
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * User Agent Class.
 *
 * Identifies the platform, browser, robot, or mobile device of the browsing agent
 *
 * @category	User Agent
 *
 * @author		EllisLab Dev Team
 *
 * @link		https://codeigniter.com/user_guide/libraries/user_agent.html
 */
class CI_User_agent
{
    /**
     * Current user-agent.
     *
     * @var string
     */
    public $agent = null;

    /**
     * Flag for if the user-agent belongs to a browser.
     *
     * @var bool
     */
    public $is_browser = false;

    /**
     * Flag for if the user-agent is a robot.
     *
     * @var bool
     */
    public $is_robot = false;

    /**
     * Flag for if the user-agent is a mobile browser.
     *
     * @var bool
     */
    public $is_mobile = false;

    /**
     * Languages accepted by the current user agent.
     *
     * @var array
     */
    public $languages = [];

    /**
     * Character sets accepted by the current user agent.
     *
     * @var array
     */
    public $charsets = [];

    /**
     * List of platforms to compare against current user agent.
     *
     * @var array
     */
    public $platforms = [];

    /**
     * List of browsers to compare against current user agent.
     *
     * @var array
     */
    public $browsers = [];

    /**
     * List of mobile browsers to compare against current user agent.
     *
     * @var array
     */
    public $mobiles = [];

    /**
     * List of robots to compare against current user agent.
     *
     * @var array
     */
    public $robots = [];

    /**
     * Current user-agent platform.
     *
     * @var string
     */
    public $platform = '';

    /**
     * Current user-agent browser.
     *
     * @var string
     */
    public $browser = '';

    /**
     * Current user-agent version.
     *
     * @var string
     */
    public $version = '';

    /**
     * Current user-agent mobile name.
     *
     * @var string
     */
    public $mobile = '';

    /**
     * Current user-agent robot name.
     *
     * @var string
     */
    public $robot = '';

    /**
     * HTTP Referer.
     *
     * @var mixed
     */
    public $referer;

    // --------------------------------------------------------------------

    /**
     * Constructor.
     *
     * Sets the User Agent and runs the compilation routine
     *
     * @return void
     */
    public function __construct()
    {
        $this->_load_agent_file();

        if (isset($_SERVER['HTTP_USER_AGENT'])) {
            $this->agent = trim($_SERVER['HTTP_USER_AGENT']);
            $this->_compile_data();
        }

        log_message('info', 'User Agent Class Initialized');
    }

    // --------------------------------------------------------------------

    /**
     * Compile the User Agent Data.
     *
     * @return bool
     */
    protected function _load_agent_file()
    {
        if (($found = file_exists(APPPATH.'config/user_agents.php'))) {
            include APPPATH.'config/user_agents.php';
        }

        if (file_exists(APPPATH.'config/'.ENVIRONMENT.'/user_agents.php')) {
            include APPPATH.'config/'.ENVIRONMENT.'/user_agents.php';
            $found = true;
        }

        if ($found !== true) {
            return false;
        }

        $return = false;

        if (isset($platforms)) {
            $this->platforms = $platforms;
            unset($platforms);
            $return = true;
        }

        if (isset($browsers)) {
            $this->browsers = $browsers;
            unset($browsers);
            $return = true;
        }

        if (isset($mobiles)) {
            $this->mobiles = $mobiles;
            unset($mobiles);
            $return = true;
        }

        if (isset($robots)) {
            $this->robots = $robots;
            unset($robots);
            $return = true;
        }

        return $return;
    }

    // --------------------------------------------------------------------

    /**
     * Compile the User Agent Data.
     *
     * @return bool
     */
    protected function _compile_data()
    {
        $this->_set_platform();

        foreach (['_set_robot', '_set_browser', '_set_mobile'] as $function) {
            if ($this->$function() === true) {
                break;
            }
        }
    }

    // --------------------------------------------------------------------

    /**
     * Set the Platform.
     *
     * @return bool
     */
    protected function _set_platform()
    {
        if (is_array($this->platforms) && count($this->platforms) > 0) {
            foreach ($this->platforms as $key => $val) {
                if (preg_match('|'.preg_quote($key).'|i', $this->agent)) {
                    $this->platform = $val;

                    return true;
                }
            }
        }

        $this->platform = 'Unknown Platform';

        return false;
    }

    // --------------------------------------------------------------------

    /**
     * Set the Browser.
     *
     * @return bool
     */
    protected function _set_browser()
    {
        if (is_array($this->browsers) && count($this->browsers) > 0) {
            foreach ($this->browsers as $key => $val) {
                if (preg_match('|'.$key.'.*?([0-9\.]+)|i', $this->agent, $match)) {
                    $this->is_browser = true;
                    $this->version = $match[1];
                    $this->browser = $val;
                    $this->_set_mobile();

                    return true;
                }
            }
        }

        return false;
    }

    // --------------------------------------------------------------------

    /**
     * Set the Robot.
     *
     * @return bool
     */
    protected function _set_robot()
    {
        if (is_array($this->robots) && count($this->robots) > 0) {
            foreach ($this->robots as $key => $val) {
                if (preg_match('|'.preg_quote($key).'|i', $this->agent)) {
                    $this->is_robot = true;
                    $this->robot = $val;
                    $this->_set_mobile();

                    return true;
                }
            }
        }

        return false;
    }

    // --------------------------------------------------------------------

    /**
     * Set the Mobile Device.
     *
     * @return bool
     */
    protected function _set_mobile()
    {
        if (is_array($this->mobiles) && count($this->mobiles) > 0) {
            foreach ($this->mobiles as $key => $val) {
                if (false !== (stripos($this->agent, $key))) {
                    $this->is_mobile = true;
                    $this->mobile = $val;

                    return true;
                }
            }
        }

        return false;
    }

    // --------------------------------------------------------------------

    /**
     * Set the accepted languages.
     *
     * @return void
     */
    protected function _set_languages()
    {
        if ((count($this->languages) === 0) && !empty($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
            $this->languages = explode(',', preg_replace('/(;\s?q=[0-9\.]+)|\s/i', '', strtolower(trim($_SERVER['HTTP_ACCEPT_LANGUAGE']))));
        }

        if (count($this->languages) === 0) {
            $this->languages = ['Undefined'];
        }
    }

    // --------------------------------------------------------------------

    /**
     * Set the accepted character sets.
     *
     * @return void
     */
    protected function _set_charsets()
    {
        if ((count($this->charsets) === 0) && !empty($_SERVER['HTTP_ACCEPT_CHARSET'])) {
            $this->charsets = explode(',', preg_replace('/(;\s?q=.+)|\s/i', '', strtolower(trim($_SERVER['HTTP_ACCEPT_CHARSET']))));
        }

        if (count($this->charsets) === 0) {
            $this->charsets = ['Undefined'];
        }
    }

    // --------------------------------------------------------------------

    /**
     * Is Browser.
     *
     * @param string $key
     *
     * @return bool
     */
    public function is_browser($key = null)
    {
        if (!$this->is_browser) {
            return false;
        }

        // No need to be specific, it's a browser
        if ($key === null) {
            return true;
        }

        // Check for a specific browser
        return isset($this->browsers[$key]) && $this->browser === $this->browsers[$key];
    }

    // --------------------------------------------------------------------

    /**
     * Is Robot.
     *
     * @param string $key
     *
     * @return bool
     */
    public function is_robot($key = null)
    {
        if (!$this->is_robot) {
            return false;
        }

        // No need to be specific, it's a robot
        if ($key === null) {
            return true;
        }

        // Check for a specific robot
        return isset($this->robots[$key]) && $this->robot === $this->robots[$key];
    }

    // --------------------------------------------------------------------

    /**
     * Is Mobile.
     *
     * @param string $key
     *
     * @return bool
     */
    public function is_mobile($key = null)
    {
        if (!$this->is_mobile) {
            return false;
        }

        // No need to be specific, it's a mobile
        if ($key === null) {
            return true;
        }

        // Check for a specific robot
        return isset($this->mobiles[$key]) && $this->mobile === $this->mobiles[$key];
    }

    // --------------------------------------------------------------------

    /**
     * Is this a referral from another site?
     *
     * @return bool
     */
    public function is_referral()
    {
        if (!isset($this->referer)) {
            if (empty($_SERVER['HTTP_REFERER'])) {
                $this->referer = false;
            } else {
                $referer_host = @parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST);
                $own_host = parse_url(config_item('base_url'), PHP_URL_HOST);

                $this->referer = ($referer_host && $referer_host !== $own_host);
            }
        }

        return $this->referer;
    }

    // --------------------------------------------------------------------

    /**
     * Agent String.
     *
     * @return string
     */
    public function agent_string()
    {
        return $this->agent;
    }

    // --------------------------------------------------------------------

    /**
     * Get Platform.
     *
     * @return string
     */
    public function platform()
    {
        return $this->platform;
    }

    // --------------------------------------------------------------------

    /**
     * Get Browser Name.
     *
     * @return string
     */
    public function browser()
    {
        return $this->browser;
    }

    // --------------------------------------------------------------------

    /**
     * Get the Browser Version.
     *
     * @return string
     */
    public function version()
    {
        return $this->version;
    }

    // --------------------------------------------------------------------

    /**
     * Get The Robot Name.
     *
     * @return string
     */
    public function robot()
    {
        return $this->robot;
    }

    // --------------------------------------------------------------------

    /**
     * Get the Mobile Device.
     *
     * @return string
     */
    public function mobile()
    {
        return $this->mobile;
    }

    // --------------------------------------------------------------------

    /**
     * Get the referrer.
     *
     * @return bool
     */
    public function referrer()
    {
        return empty($_SERVER['HTTP_REFERER']) ? '' : trim($_SERVER['HTTP_REFERER']);
    }

    // --------------------------------------------------------------------

    /**
     * Get the accepted languages.
     *
     * @return array
     */
    public function languages()
    {
        if (count($this->languages) === 0) {
            $this->_set_languages();
        }

        return $this->languages;
    }

    // --------------------------------------------------------------------

    /**
     * Get the accepted Character Sets.
     *
     * @return array
     */
    public function charsets()
    {
        if (count($this->charsets) === 0) {
            $this->_set_charsets();
        }

        return $this->charsets;
    }

    // --------------------------------------------------------------------

    /**
     * Test for a particular language.
     *
     * @param string $lang
     *
     * @return bool
     */
    public function accept_lang($lang = 'en')
    {
        return in_array(strtolower($lang), $this->languages(), true);
    }

    // --------------------------------------------------------------------

    /**
     * Test for a particular character set.
     *
     * @param string $charset
     *
     * @return bool
     */
    public function accept_charset($charset = 'utf-8')
    {
        return in_array(strtolower($charset), $this->charsets(), true);
    }

    // --------------------------------------------------------------------

    /**
     * Parse a custom user-agent string.
     *
     * @param string $string
     *
     * @return void
     */
    public function parse($string)
    {
        // Reset values
        $this->is_browser = false;
        $this->is_robot = false;
        $this->is_mobile = false;
        $this->browser = '';
        $this->version = '';
        $this->mobile = '';
        $this->robot = '';

        // Set the new user-agent string and parse it, unless empty
        $this->agent = $string;

        if (!empty($string)) {
            $this->_compile_data();
        }
    }
}
