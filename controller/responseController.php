<?php

class ResponseController{   

    static public $response=null;

    static public function response($cod,$statement=null){
        switch($cod){
            case 101://Validacion de correo
                self::setError($cod,'El campo '.$statement.' no cumple con condiciones mínimas');
                break;
            case 201://Get Users
                self::setResult($cod,$statement);
                break;
            case 202://Create User
                self::setInfo($cod,'Usuario creado');
                break;
            case 203://Update User
                self::setInfo($cod,'Usuario actualizado');
                break;
            case 204://Delete User
                self::setInfo($cod,'Usuario elimindo');
                break;
            case 205://Delete User
                self::setInfo($cod,'Usuario activado');
                break;
            case 208: //Usuario no existe
                self::setError($cod,'Usuario ya existe');
                break;
            case 209: //Usuario no existe
                self::setError($cod,'Usuario no existe');
                break;
            case 404:
                self::setError($cod,'Ruta no encontrada');
                break;
            case 501:
                self::setInfo($cod,'OK');
                self::$response['credentials'] = $statement;
                break;
            case 503://Error de credenciales
                self::setError($cod,'ERROR EN CREDENCIALES');
                self::$response['credentials'] = null;
                self::$response['header'] = "HTTP/1.1 400 FAIL";
                break;
            case 504://No credentials
                self::setError($cod,'NO TIENE CREDENCIALES');
                break;
            case 505:
                self::setError($cod,'NO TIENE ACCESO');
                break;
        }
        echo json_encode(self::$response,JSON_UNESCAPED_UNICODE);
    }

    static private function setInfo($status,$message){
        self::$response['info']['status']=$status;
        self::$response['info']['message']=$message;
    }

    static private function setError($status,$message){
        self::$response['error']['status']=$status;
        self::$response['error']['message']=$message;
    }
    
    static private function setResult($status,$statement){
        self::$response['info']['status']=$status;
        self::$response['info']['count']=$statement->rowCount();
        self::$response['response']=$statement->fetchAll();

    }
}


/*
Route not found
Validation
Response
Confirmation (Update,Create,Delete)
Credentials warning
Error de conexion
*/
?>