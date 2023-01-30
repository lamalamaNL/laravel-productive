<?php

namespace LamaLama\Productive\Resources;

use LamaLama\Productive\Exceptions\ApiException;
use LamaLama\Productive\ProductiveApiClient;

class Task extends BaseResource
{
    /**
     * @var string
     */
    public $resource;

    /**
     * Id of the task (on the Productive platform).
     *
     * @var string
     */
    public $id;

    /**
     * Title of the task.
     *
     * @var string
     */
    public $title;

    /**
     * Description of the task.
     *
     * @var string
     */
    public $description;

    /**
     * @return \LamaLama\Productive\Resources\Task
     * @throws \LamaLama\Productive\Exceptions\ApiException
     */
    public function update()
    {
        $body = [
            "title" => $this->title,
            "description" => $this->description,
        ];

        $result = $this->client->tasks->update($this->id, $body);

        return ResourceFactory::createFromApiResult($result, new Task($this->client));
    }
}
