<?php
function safeInt($int)
{
	return filter_var($int, FILTER_VALIDATE_INT);
}
function safeString($str)
{
	return filter_var($str, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW);
}
?>