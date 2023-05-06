<?php

namespace KLib2\Document;

class Documentation {
    public static function getAnnotationValue($methodName, $annotationName) {

      $reflectionMethod = new \ReflectionMethod($methodName);
      
      $comment = $reflectionMethod->getDocComment();

      $pattern = '/@'.$annotationName.'\s+([^\s]+)/';
  
      if (preg_match($pattern, $comment, $matches)) {
        return $matches[1];
      }
  
      return null;
    }
  }
  