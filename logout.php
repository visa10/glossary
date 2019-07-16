<?php
/**
 * Created by IntelliJ IDEA.
 * User: vss
 * Date: 15.07.19
 * Time: 23:36
 */


	session_start();
	session_destroy();
	header("location: index.php");