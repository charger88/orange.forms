<?php

require_once __DIR__ . '/autoload.php';

use \Orange\Forms\Fields\Inputs\Text;
use \Orange\Forms\Fields\Buttons\Submit;

class XSRFProtectedForm extends \Orange\Forms\Form
{

    protected function init($params)
    {
        $this->addField((new Text('name', 'Name')));
        $this->addField((new Text('surname', 'Surname')));
        $this->addField((new Submit('my-submit', 'Submit')));
        $this->enableXSRFProtection();
    }

}

\Orange\Forms\XSRFProtection::addUniqueKeyComponent(getenv('REMOTE_ADDR'));

$form = new XSRFProtectedForm();
$form->setValues($_POST);

?>
<html>
<head>
    <style>
        .orange-forms-field-errors {
            color: red;
        }
    </style>
    <script type="text/javascript">
        function broke(){
            document.querySelector('input[name="_xsrf_protection_code"]').value = '----';
            document.querySelector('#broke-wrapper').innerHTML = 'Broken';
            return false;
        }
    </script>
</head>
<body>
<?php if ($_POST){ ?>
<div><?php echo $form->checkXSRF() ? 'XSRF - OK' : 'XSRF - ERROR'; ?></div>
<?php } ?>
<?php echo $form->getHTML(); ?>
<div id="broke-wrapper"><a href="#" onclick="return broke();">Broke XSRF key code</a></div>
</body>
</html>