<?php


class DArrayHelper
{
    /**
     * Convert array to object
     * <pre>
     *      $reqObj = $this->getRequestObject($_REQUEST, array(
     *          'property1', // convert $_REQUEST['property1'] to $reqObj->property1
     *          'property2'=>'foo', // convert $_REQUEST['property2'] to $reqObj->foo
     *          'Form[property3]'=>'bar', // convert $_REQUEST['Form']['property3'] to $reqObj->bar
     *          'Form[property4]', // convert $_REQUEST['Form']['property4'] to $reqObj->property4
     *      ));
     * </pre>
     * @param mixed $array
     * @param mixed $attributesMap
     * @return StdClass
     */
    public static function arrayToObject($array, $attributesMap)
    {
        $request = new StdClass;

        foreach ($attributesMap as $fromAttr => $toAttr) {
            if (is_int($fromAttr)) {
                $fromAttr = $toAttr;
                $toAttr = null;
            }

            $attrName = '';

            $subs = explode('[', $fromAttr);

            $val = $array;

            while ($sub = trim(array_shift($subs), ']')) {
                $attrName = $sub;
                $val = isset($val[$sub]) ? $val[$sub] : null;
            }

            if (!$toAttr) {
                $toAttr = $attrName;
            }

            $request->$toAttr = $val;
        }

        return $request;
    }

    public static function extract($array, $attributes)
    {
        $resultArray = [];

        foreach ($attributes as $attr) {
            $resultArray[$attr] = isset($array[$attr]) ? $array[$attr] : null;
        }

        return $resultArray;
    }

    public static function clean($array)
    {
        $resultArray = [];

        foreach ($array as $attr => $val) {
            if ($val) {
                $resultArray[$attr] = $val;
            }
        }

        return $resultArray;
    }
}
