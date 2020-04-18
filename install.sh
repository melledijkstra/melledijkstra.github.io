#!/bin/bash

if ! type "ruby" > /dev/null; then
  echo 'First install ruby, then run again'
else
  ruby --version

  gem install bundler

  bundle install
fi
