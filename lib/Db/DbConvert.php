<?php
/**
 * чисто формальный класс
 * чтоб иметь доступ к методу query
 */
class DbConvert extends DbModel {
	
	const SQL_UserProfile = "SELECT name, birthdate, data FROM userProfile";

	
}