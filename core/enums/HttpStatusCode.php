<?php

namespace App\Core\Enums;

enum HttpStatusCode: int
{
    case CONTINUE = 100;
    case SWITCHING_PROTOCOLS = 101;
    case OK = 200;
    case CREATED = 201;
    case ACCEPTED = 202;
    case NON_AUTHORITATIVE_INFORMATION = 203;
    case NO_CONTENT = 204;
    case RESET_CONTENT = 205;
    case PARTIAL_CONTENT = 206;
    case MULTIPLE_CHOICES = 300;
    case MOVED_PERMANENTLY = 301;
    case MOVED_TEMPORARILY = 302;
    case SEE_OTHER = 303;
    case NOT_MODIFIED = 304;
    case USE_PROXY = 305;
    case BAD_REQUEST = 400;
    case UNAUTHORIZED = 401;
    case PAYMENT_REQUIRED = 402;
    case FORBIDDEN = 403;
    case NOT_FOUND = 404;
    case METHOD_NOT_ALLOWED = 405;
    case NOT_ACCEPTABLE = 406;
    case PROXY_AUTHENTICATION_REQUIRED = 407;
    case REQUEST_TIME_OUT = 408;
    case CONFLICT = 409;
    case GONE = 410;
    case LENGTH_REQUIRED = 411;
    case PRECONDITION_FAILED = 412;
    case REQUEST_ENTITY_TOO_LARGE = 413;
    case REQUEST_URI_TOO_LARGE = 414;
    case UNSUPPORTED_MEDIA_TYPE = 415;
    case INTERNAL_SERVER_ERROR = 500;
    case NOT_IMPLEMENTED = 501;
    case BAD_GATEWAY = 502;
    case SERVICE_UNAVAILABLE = 503;
    case GATEWAY_TIME_OUT = 504;
    case HTTP_VERSION_NOT_SUPPORTED = 505;

    public function getText(): string
    {
        switch ($this) {
            case self::CONTINUE:
                return 'Continue';
            case self::SWITCHING_PROTOCOLS:
                return 'Switching Protocols';
            case self::OK:
                return 'OK';
            case self::CREATED:
                return 'Created';
            case self::ACCEPTED:
                return 'Accepted';
            case self::NON_AUTHORITATIVE_INFORMATION:
                return 'Non-Authoritative Information';
            case self::NO_CONTENT:
                return 'No Content';
            case self::RESET_CONTENT:
                return 'Reset Content';
            case self::PARTIAL_CONTENT:
                return 'Partial Content';
            case self::MULTIPLE_CHOICES:
                return 'Multiple Choices';
            case self::MOVED_PERMANENTLY:
                return 'Moved Permanently';
            case self::MOVED_TEMPORARILY:
                return 'Moved Temporarily';
            case self::SEE_OTHER:
                return 'See Other';
            case self::NOT_MODIFIED:
                return 'Not Modified';
            case self::USE_PROXY:
                return 'Use Proxy';
            case self::BAD_REQUEST:
                return 'Bad Request';
            case self::UNAUTHORIZED:
                return 'Unauthorized';
            case self::PAYMENT_REQUIRED:
                return 'Payment Required';
            case self::FORBIDDEN:
                return 'Forbidden';
            case self::NOT_FOUND:
                return 'Requested Path or Method Not Found';
            case self::METHOD_NOT_ALLOWED:
                return 'Method Not Allowed';
            case self::NOT_ACCEPTABLE:
                return 'Not Acceptable';
            case self::PROXY_AUTHENTICATION_REQUIRED:
                return 'Proxy Authentication Required';
            case self::REQUEST_TIME_OUT:
                return 'Request Time-out';
            case self::CONFLICT:
                return 'Conflict';
            case self::GONE:
                return 'Gone';
            case self::LENGTH_REQUIRED:
                return 'Length Required';
            case self::PRECONDITION_FAILED:
                return 'Precondition Failed';
            case self::REQUEST_ENTITY_TOO_LARGE:
                return 'Request Entity Too Large';
            case self::REQUEST_URI_TOO_LARGE:
                return 'Request-URI Too Large';
            case self::UNSUPPORTED_MEDIA_TYPE:
                return 'Unsupported Media Type';
            case self::INTERNAL_SERVER_ERROR:
                return 'Internal Server Error';
            case self::NOT_IMPLEMENTED:
                return 'Not Implemented';
            case self::BAD_GATEWAY:
                return 'Bad Gateway';
            case self::SERVICE_UNAVAILABLE:
                return 'Service Unavailable';
            case self::GATEWAY_TIME_OUT:
                return 'Gateway Time-out';
            case self::HTTP_VERSION_NOT_SUPPORTED:
                return 'HTTP Version not supported';
            default:
                return '';
        }
    }
}
