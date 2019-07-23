<?php


namespace Tests\Feature\Groups;


use App\Entities\Groups\Group;
use Tests\Feature\FeatureTestCase;

class GroupControllerTest extends FeatureTestCase
{
    private $entity;

    public function setUp(): void
    {
        parent::setUp();
        $this->entity = factory(Group::class)->create();
    }

    public function testIndex()
    {

    }
}
