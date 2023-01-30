<?php

namespace LamaLama\Productive\Resources;

class TaskCollection extends CursorCollection
{
    /**
     * @return string
     */
    public function getCollectionResourceName()
    {
        return "tasks";
    }

    /**
     * @return BaseResource
     */
    protected function createResourceObject()
    {
        return new Task($this->client);
    }
}
