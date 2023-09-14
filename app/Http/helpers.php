<?php

if (! function_exists('responseJson')) {
    function responseJson($message, $status) {
        return response()->json([$message], $status);
    }
}

if (! function_exists('responseJsonSuccess')) {
    function responseJsonSuccess() {
        return response()->json(['message' => 'The operation was successful.'], 200);
    }
}

if (! function_exists('responseJsonError')) {
    function responseJsonError($message, $status) {
        return response()->json([$message], $status);
    }
}

if (! function_exists('requestAddParam')) {
    function requestAddParam($parameter) {
        $id = request()->route()->parameter($parameter);
        request()->request->add(['id' => $id]);
    }
}


?>
