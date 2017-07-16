#!/bin/bash

libraries="
debug;vendor/symfony/symfony/src/Symfony/Component/Debug/
finder;vendor/symfony/symfony/src/Symfony/Component/Finder/
http-foundation;vendor/symfony/symfony/src/Symfony/Component/HttpFoundation/
http-kernel;vendor/symfony/symfony/src/Symfony/Component/HttpKernel/
routing;vendor/symfony/symfony/src/Symfony/Component/Routing/
"

path=$(pwd)

for library in $libraries
do
  params=(${library//;/ })

  symlink_path="${path}/vendor/symfony/${params[0]}"
  library_path="${path}/${params[1]}"

  if [ ! -L ${symlink_path} ] ; then
    echo "linking ${library_path}"
    ln -s $library_path $symlink_path
  fi
done
