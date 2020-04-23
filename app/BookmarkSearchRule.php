<?php

namespace App;

use ScoutElastic\SearchRule;

class BookmarkSearchRule extends SearchRule
{

    /**
     * @inheritdoc
     */
    public function buildQueryPayload()
    {
        $query = $this->builder->query;

        return [
            'must' => [
                'multi_match' => [
                    'query' => $query,
                    'fields' => ['title', 'url_origin', 'meta_description', 'meta_keywords'],
                    'type' => 'phrase_prefix',
                ],
            ],
        ];
    }
}
