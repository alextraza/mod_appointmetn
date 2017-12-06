<?php

class ModAppointmentHelper
{
    protected static $params;
    public static function getHello($params)
    {
        self::$params = $params;
        $document = JFactory::getDocument();
        $document->addScript('modules/mod_appointment/assets/app.js');
        $document->addStyleSheet('modules/mod_appointment/assets/app.css');
    }

    /**
     * Get ajax request
     *
     * @return string
     */
    public static function postAjax()
    {
        jimport('joomla.application.module.helper');
        $input = JFactory::getApplication()->input;

        $request['name'] = $input->getString('name', '');
        $request['email'] = $input->getString('email', '');
        if (!$request['email']) {
            unset($request['email']);
        }
        $request['phone'] = $input->getString('phone', '');
        $request['text'] = $input->getString('text', '');

        $validate = self::validateInputs($request);

        if ($validate['status'] == 'success') {
            self::sendEmail($request, self::$params);
        }

        return json_encode($validate);
    }

    /**
     * Send email
     *
     * @param array() $request - sender fields
     * @param object() $params - module params
     */
    private static function sendEmail($request, $params)
    {
        extract($request);
		$config = JFactory::getConfig();
        $emaillist = [$email, $config->get('config.mailfrom')];
		$mailer = JFactory::getMailer();
		$mailer->IsHTML(true);
        $mailer->setSender([$config->get('config.mailfrom'), $config->get('config.fromname')]);

        $mailer->addRecipient('osmetolog@urk.net');
        $mailer->addCC("nadia.sprava@gmail.com");
        $mailer->setSubject('Новий запис на прийом');
        $body = '<h2>Запис на прийом</h2><br/><br/>Ім\'я: '.$name;
        if (isset($email)) {
            $body .= '<br/>E-mail: '.$email;
        }
        $body .= '<br/>Телефон: '.$phone;
        $body .= '<br/>Причина візиту: '.$text.'<br/>';
		$mailer->setBody($body);
		$mailer->send();
    }

    /**
     * Check data
     *
     * @param array() $request
     */
    private static function validateInputs($request)
    {
        foreach ($request as $key => $value) {
            if ($value == '') {
                return [
                    'status' => 'error',
                    'message' => [
                        'field' => $key,
                        'text' => 'Поле обов\'язкове для заповнення'
                    ]
                ];
            }

            if ($key == 'email') {
                $validate = self::emailValidate($value);
                if (!$validate) {
                    return [
                        'status' => 'error',
                        'message' => [
                            'field' => $key,
                            'text' => 'Невірний формат email'
                        ]
                    ];
                }
            }
        }
        return [
            'status' => 'success',
            'message' => '<div class="success">Дякуємо за Ваш запис! Ми зв\'яжемося з Вами у найближчий час для уточнення дати і часу прийому!</div>'
        ];
    }

    private static function emailValidate($email)
    {
        $pattern = '/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/i';
        if (!preg_match($pattern, $email)) {
            return false;
        }
        return true;
    }

}
