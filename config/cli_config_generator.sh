#!/bin/bash

if [ $# -eq 0 ]; then
  echo "Usage: $0 <input_value>"
  exit 1
fi

input_value="$1"

php_content="<?php

require __DIR__.'/vendor/autoload.php';

\$table = require __DIR__.'/config/cli-config-base.php';

return \$table['${input_value}'];
"

echo "$php_content" > cli-config.php
