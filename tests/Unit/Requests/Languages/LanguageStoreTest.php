<?php


namespace Tests\Unit\Requests\Languages;


use App\Http\Requests\Languages\LanguageStoreRequest;
use Tests\TestCase;

class LanguageStoreTest extends TestCase
{
    private $validator;
    private $rules;

    protected function setUp(): void
    {
        parent::setUp();
        $this->rules = (new LanguageStoreRequest())->rules();
        $this->validator = $this->app['validator'];
    }

    public function testValidName()
    {
        $this->assertTrue($this->validateField('name','russian'));
        $this->assertFalse($this->validateField('name',43243));
    }

    private function getFieldValidator($field, $value)
    {
        return $this->validator->make(
            [$field => $value],
            [$field => $this->rules[$field]]
        );
    }

    private function validateField($field, $value)
    {
        return $this->getFieldValidator($field, $value)->passes();
    }


}
