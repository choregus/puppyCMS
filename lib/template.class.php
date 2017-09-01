<?php

/****************************************************************************************
* A tiny Template Engine
****************************************************************************************/
class Template
{
    // Private Global Class Member Variables
    private $TEMPLATE_DATASTACK = array();
    private $TEMPLATE_STACKLEVEL = 0;
    private $TEMPLATE_FILE = "";


    /************************************************************************************
    * Create a new Template-Instance
    ************************************************************************************/
    public function __construct($tpl_file)
    {
        $this->TEMPLATE_FILE = $tpl_file;
    }

    /************************************************************************************
    * Assig a value to the template
    ************************************************************************************/
    public function assign($key, $value)
    {
        $this->TEMPLATE_DATASTACK[0][$key] = $value;
    }

    /************************************************************************************
    * Ĉoncat the data and the template and print it out or return it
    ************************************************************************************/
    public function display($strOutput = false)
    {
        // Load Template File Content
        $template = file_get_contents($this->TEMPLATE_FILE);

        // Start Ob-Buffer if enabled
        if ($strOutput) { ob_start(); }
        
        // Replace the placeholder in the template with php statements
        $template = preg_replace('~\{LOOP:(\w+)\}~', '<?php foreach ($this->TEMPLATE_DATASTACK[$this->TEMPLATE_STACKLEVEL][\'$1\'] as $ELEMENT) { $this->wrap($ELEMENT); ?>', $template);
        $template = preg_replace('~\{ENDLOOP\}~', '<?php $this->unwrap(); } ?>', $template);
        $template = preg_replace('~\{IF:(\w+)\}~', '<?php if($this->TEMPLATE_DATASTACK[$this->TEMPLATE_STACKLEVEL][\'$1\']) { ?>', $template);
        $template = preg_replace('~\{ELSE\}~', '<?php } else { ?>', $template);
        $template = preg_replace('~\{ENDIF\}~', '<?php } ?>', $template);
        $template = preg_replace('~\{(\w+)\}~', '<?php $this->showVariable(\'$1\'); ?>', $template);
        
        $template = '?>' . $template;

        // Evaluate the template and print it out
        echo(eval ($template));

        // Return Ob-Buffer-Content if Ob-Buffer is enabled
        if ($strOutput) { return ob_get_clean(); }
    }

    /************************************************************************************
    * Show the content of a variable
    ************************************************************************************/
    private function showVariable($name)
    {
        // make a alias for the current StacklevelData
        $data = $this->TEMPLATE_DATASTACK[$this->TEMPLATE_STACKLEVEL];

        // Return the value of the placeholder or the placeholdername if there is no value
        echo (isset($data) && isset($data[$name])) ? $data[$name] : '{'.$name.'}';
    }

    /************************************************************************************
    * Make a new indentionlevel for a loop and set the value
    ************************************************************************************/
    private function wrap($element)
    {
        // create a new stacklevel and set the values of the level
        $this->TEMPLATE_DATASTACK[++$this->TEMPLATE_STACKLEVEL] = $element;
    }

    /************************************************************************************
    * Delete the current indentionlevel for a loop and set the value to the previous
    ************************************************************************************/
    private function unwrap()
    {
        // delete the current stacklevel und reset the level back to the previous
        $this->TEMPLATE_STACKLEVEL--;
    }

}

?>