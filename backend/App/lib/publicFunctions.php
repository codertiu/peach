<?php

function path($path){
    return realpath(dirname(__FILE__) . $path);
}
