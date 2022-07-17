<?php


namespace app\models;

use DateTime;
use thecodeholic\phpmvc\db\DbModel;
use thecodeholic\phpmvc\UserModel;

/**
 * Class Register
 *
 * @author  Zura Sekhniashvili <zurasekhniashvili@gmail.com>
 * @package app\models
 */
class Buyer extends DbModel
{

    const RULE_INTEGER = 'integer';
    const RULE_DATE = 'date';
    const RULE_ALPHA = 'alpha';
    const RULE_MAX_WORD = 'maxword';
    const RULE_DIGIT = 'digit';
    const RULE_EQUAL = 'equal';

    public int $id = 0;
    public string $amount = '';
    public string $buyer = '';
    public string $receipt_id = '';
    public string $items = '';
    public string $buyer_email = '';
    public string $buyer_ip = '';
    public string $note = '';
    public string $city = '';
    public string $phone = '';
    public string $hash_key = '';
    public string $entry_at = '';
    public string $entry_by = '';
    

    public static function tableName(): string
    {
        return 'buyer';
    }

    public function attributes(): array
    {
        return ['id', 'amount', 'note', 'buyer', 'buyer_email', 'buyer_ip', 'city', 'phone', 'hash_key', 'receipt_id', 'items', 'entry_by'];
    }

    public function labels(): array
    {
        return [
            'id' => 'ID',
            'amount' => 'Amount',
            'buyer' => 'buyer',
            'receipt_id' => 'receipt_id',
            'items' => 'items',
            'buyer_email' => 'Buyer_email',
            'buyer_ip' => 'buyer_ip',
            'note' => 'note',
            'city' => 'city',
            'phone' => 'phone',
            'hash_key' => 'hash_key',
            'entry_at' => 'entry_at',
            'entry_by' => 'entry_by',
        ];
    }

    public function validate()
    {
        foreach ($this->rules() as $attribute => $rules) {
            $value = $this->{$attribute};
            foreach ($rules as $rule) {
                $ruleName = $rule;
                if (!is_string($rule)) {
                    $ruleName = $rule[0];
                }
                if ($ruleName === self::RULE_REQUIRED && !$value) {
                    $this->addErrorByRule($attribute, self::RULE_REQUIRED);
                }
                if ($ruleName === self::RULE_EMAIL && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->addErrorByRule($attribute, self::RULE_EMAIL);
                }
                if ($ruleName === self::RULE_MIN && strlen($value) < $rule['min']) {
                    $this->addErrorByRule($attribute, self::RULE_MIN, ['min' => $rule['min']]);
                }
                if ($ruleName === self::RULE_MAX && strlen($value) > $rule['max']) {
                    $this->addErrorByRule($attribute, self::RULE_MAX);
                }
                if ($ruleName === self::RULE_MATCH && $value !== $this->{$rule['match']}) {
                    $this->addErrorByRule($attribute, self::RULE_MATCH, ['match' => $rule['match']]);
                }
                if ($ruleName === self::RULE_INTEGER && !( is_int( (int) $value) && is_numeric($value) ) ) {
                    $this->addErrorByRule($attribute, self::RULE_INTEGER);
                }
                if ($ruleName === self::RULE_DATE && !$this->validateDate($value) ) {
                    $this->addErrorByRule($attribute, self::RULE_DATE);
                }
                if ($ruleName === self::RULE_ALPHA && !preg_match ("/^[a-zA-Z0-9\s]+$/",$value) ) {
                    $this->addErrorByRule($attribute, self::RULE_ALPHA);
                }
                if ($ruleName === self::RULE_MAX_WORD && !( count( explode(' ', $value) ) < $rule['maxword'] ) ) {
                    $this->addErrorByRule($attribute, self::RULE_MAX_WORD);
                }
                if ($ruleName === self::RULE_DIGIT && !preg_replace('/\D/', '', $value) ) {
                    $this->addErrorByRule($attribute, self::RULE_DIGIT);
                }
                if ($ruleName === self::RULE_EQUAL && !( strlen($value) == $rule['equal'] ) ) {
                    $this->addErrorByRule($attribute, self::RULE_EQUAL);
                }
                
                

                if ($ruleName === self::RULE_UNIQUE) {
                    $className = $rule['class'];
                    $uniqueAttr = $rule['attribute'] ?? $attribute;
                    $tableName = $className::tableName();
                    $db = Application::$app->db;
                    $statement = $db->prepare("SELECT * FROM $tableName WHERE $uniqueAttr = :$uniqueAttr");
                    $statement->bindValue(":$uniqueAttr", $value);
                    $statement->execute();
                    $record = $statement->fetchObject();
                    if ($record) {
                        $this->addErrorByRule($attribute, self::RULE_UNIQUE);
                    }
                }
            }
        }
        return empty($this->errors);
    }

    public function rules()
    {
        return [
            'id' => [],
            'amount' => [self::RULE_REQUIRED, self::RULE_INTEGER],
            'buyer' => [self::RULE_REQUIRED, [self::RULE_MAX, 'max' => 20] ],
            'receipt_id' => [self::RULE_REQUIRED],
            'items' => [self::RULE_REQUIRED],
            'buyer_email' => [self::RULE_REQUIRED, self::RULE_EMAIL],
            'buyer_ip' => [],
            'note' => [self::RULE_REQUIRED, [self::RULE_MAX, 'max' => 30] ],
            'city' => [self::RULE_REQUIRED],
            'phone' => [self::RULE_REQUIRED, self::RULE_DIGIT , [self::RULE_EQUAL, 'equal' => 11]],
            'hash_key' => [],
            'entry_at' => [], //[self::RULE_DATE],
            'entry_by' => [self::RULE_REQUIRED],
        ];
    }

    public function errorMessages()
    {
        return [
            self::RULE_REQUIRED => 'This field is required',
            self::RULE_EMAIL => 'This field must be valid email address',
            self::RULE_MIN => 'Min length of this field must be {min}',
            self::RULE_MAX => 'Max length of this field must be {max}',
            self::RULE_MATCH => 'This field must be the same as {match}',
            self::RULE_UNIQUE => 'Record with with this {field} already exists',
            self::RULE_INTEGER => 'This field have to be integer',
            self::RULE_DATE => 'This field have to be date',
            self::RULE_ALPHA => 'This field must be alphanumeric and space',
            self::RULE_MAX_WORD => 'This field must be less than {maxword} words',
            self::RULE_DIGIT => 'This field must be digit',
            self::RULE_EQUAL => 'This field must be equal to specified length',
        ];
    }


    
    public function save()
    {
        // $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        // var_dump($this);
        return parent::save();
    }

    public function getDisplayName(): string
    {
        return $this->firstname; //. ' ' . $this->lastname;
    }

    function validateDate($date, $format = 'Y-m-d')
    {
        $d = DateTime::createFromFormat($format, $date);
        // The Y ( 4 digits year ) returns TRUE for any integer with any number of digits so changing the comparison from == to === fixes the issue.
        return $d && $d->format($format) === $date;
    }


}