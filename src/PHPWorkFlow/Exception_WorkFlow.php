<?php
namespace PHPWorkFlow;
/**
 * Class Exception_WorkFlow
 */
class Exception_WorkFlow extends \Exception
{
    /**
     * @return bool
     */
//    public function alertOperationsViaEmail()
//    {
//        if(! Configuration_WorkFlow::get_tc_exception_notification())
//        {
//            return false;
//        }

        /**
         * @todo add email
         */
//        $Email_SmartyObj = new TCPV_Email('ops_exception');
//        $Email_SmartyObj->addRecipients(TCP_Configuration::get_tc_exception_notification_emails());
//        $Email_SmartyObj->set_greeting_name('Mosaic Ops');
//        if ($organization_name)
//        {
//            $Email_SmartyObj->assign('organization_name', $organization_name);
//        }
//        $Email_SmartyObj->assign('created_at', date('F j, Y'));
//        if ($UserObj = BOUser::User())
//        {
//            $Email_SmartyObj->assign('user_name', $UserObj->get_full_name());
//        }
//        $Email_SmartyObj->assign('stack_trace', $this->__toStringEmail());
//        return $Email_SmartyObj->send();
//        return true;
//    }

    /**
     * @return string
     *
     * @todo add code to provide better message in batch context - see Exception::__toStringEmail for guidence
     */
    public function __toString()
    {
        if (isset($_SERVER['REQUEST_METHOD'])) {
            /*
             * note the 'end anchor' tag that starts this string. This is needed in case the error/exception
             * was thrown in the
             * middle of creating another anchor tag.
             */
            return "</a><a href=\"/PHPWorkFlow\/index.php\">Home</a><div style='border:1px solid black; padding:8px; background-color:#ED7771; color:black; font-weight:bold'>
                        exception with message '" . $this->message . "' in " . $this->_getFile() . ":" . $this->_getLine() . "\n
                        <a href='#' onClick=\"  var displayProperty = document.getElementById('hide').style.display;
                                                this.innerHTML = (displayProperty == 'block') ? 'show stack trace' : 'hide stack trace';
                                                document.getElementById('hide').style.display = (displayProperty == 'block') ? 'none' : 'block'; \">
                            Show Stack Trace
                        </a>
                        <pre id='hide' style='display:none'>
                            <br>" . $this->_getTraceAsString() . "
                        </pre>
                    </div>";
        } else {
            return $this->getMessage() . PHP_EOL . $this->_getFile() . ":" . $this->_getLine() . PHP_EOL . $this->_getTraceAsString();
        }
    }

    /**
     * @return int
     */
    private function _getLine()
    {
        if($this->getPrevious())
        {
            return $this->getPrevious()->getLine();
        }
        return $this->getLine();
    }

    /**
     * @return string
     */
    private function _getFile()
    {
        if($this->getPrevious())
        {
            return $this->getPrevious()->getFile();
        }
        return $this->getFile();
    }

    /**
     * @return string
     */
    function _getTraceAsString() {
        $rtn = "";
        $count = 0;
        foreach ($this->getTrace() as $frame) {
            $args = "";
            if (isset($frame['args'])) {
                $args = [];
                foreach ($frame['args'] as $arg) {
                    if (is_string($arg)) {
                        $args[] = "'" . $arg . "'";
                    } elseif (is_array($arg)) {
                        $args[] = "Array";
                    } elseif (is_null($arg)) {
                        $args[] = 'NULL';
                    } elseif (is_bool($arg)) {
                        $args[] = ($arg) ? "true" : "false";
                    } elseif (is_object($arg)) {
                        $args[] = get_class($arg);
                    } elseif (is_resource($arg)) {
                        $args[] = get_resource_type($arg);
                    } else {
                        $args[] = $arg;
                    }
                }
                $args = join(", ", $args);
            }
            $rtn .= sprintf( "#%s %s(%s): %s(%s)\n",
                $count,
                (isset($frame['file']) ? $frame['file'] : 'NA'),
                (isset($frame['line']) ? $frame['line'] : 'NA'),
                $frame['function'],
                $args );
            $count++;
        }
        return $rtn;
    }
}
