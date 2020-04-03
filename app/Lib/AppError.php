<?php 
class AppError {
    public static function handleError($code, $description, $file = null,
        $line = null, $context = null) {
        list(, $level) = ErrorHandler::mapErrorCode($code);
        if ($level === LOG_ERR) {
            // Ignore fatal error. It will keep the PHP error message only
            return false;
        }
        return ErrorHandler::handleError(
            $code,
            $description,
            $file,
            $line,
            $context
        );
    }
}