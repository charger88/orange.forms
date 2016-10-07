<?php

require_once __DIR__ . '/autoload.php';

use \Orange\Forms\Fields\Inputs\Text;
use \Orange\Forms\Components\Fieldset;
use \Orange\Forms\Fields\Buttons\Submit;

class SimpleForm extends \Orange\Forms\Form
{

    protected function init($params)
    {

        $this->addField((new Fieldset('just-fieldset', 'My fieldset'))
            ->addField((new Text('title', 'Title')))
            ->addField((new Text('author', 'Author')))
            ->addField((new Text('year', 'Year')))
        );
        $this->addField((new Submit('my-submit', 'Save')));

    }

}

$form = new SimpleForm();
$form->setValues($_POST);

?>
<html>
<head>
</head>
<body>
<?php echo $form->getHTML(); ?>
</body>
</html>