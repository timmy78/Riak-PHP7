<?php

/*
Copyright 2014 Basho Technologies, Inc.

Licensed to the Apache Software Foundation (ASF) under one or more contributor license agreements.  See the NOTICE file
distributed with this work for additional information regarding copyright ownership.  The ASF licenses this file
to you under the Apache License, Version 2.0 (the "License"); you may not use this file except in compliance
with the License.  You may obtain a copy of the License at

  http://www.apache.org/licenses/LICENSE-2.0

Unless required by applicable law or agreed to in writing, software distributed under the License is distributed on an
"AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.  See the License for the
specific language governing permissions and limitations under the License.
*/

namespace Basho\Riak\Command\Builder;

use Basho\Riak\Command;

/**
 * Used to query a secondary index in Riak.
 *
 * <code>
 * $command = (new Command\Builder\QueryIndex($riak))
 *   ->buildBucket('users')
 *   ->withIndex('users_name', 'Knuth')
 *   ->build();
 *
 * $response = $command->execute($command);
 *
 * $index_results = $response->getIndexResults();
 * </code>
 *
 * @author Alex Moore <amoore at basho d0t com>
 */
class QueryIndex extends Command\Builder implements Command\BuilderInterface
{
    use BucketTrait;
    use IndexTrait;

    /**
     * {@inheritdoc}
     *
     * @return Command\Indexes\Query
     */
    public function build()
    {
        $this->validate();

        return new Command\Indexes\Query($this);
    }

    /**
     * {@inheritdoc}
     */
    public function validate()
    {
        $this->required('Bucket');
        $this->required('IndexName');

        if($this->isMatchQuery()) {
            $this->required('MatchValue');
        }
        else {
            $this->required('LowerBound');
            $this->required('UpperBound');
        }
    }
}