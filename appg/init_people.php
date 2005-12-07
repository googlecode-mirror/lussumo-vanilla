<?php
/*
* Copyright 2003 - 2005 Mark O'Sullivan
* This file is part of People.
* People is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; either version 2 of the License, or (at your option) any later version.
* People is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.
* You should have received a copy of the GNU General Public License along with People; if not, write to the Free Software Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
* The latest source code for People is available at www.lussumo.com
* Contact Mark O'Sullivan at mark [at] lussumo [dot] com
*
* Description: Constants and objects specific to external to the forum (ie. sign in, apply, password retrieval).
*/

// GLOBAL INCLUDES
include($Configuration["APPLICATION_PATH"]."appg/headers.php");
include($Configuration["LIBRARY_PATH"]."Utility.Functions.php");
include($Configuration["LIBRARY_PATH"]."Utility.Class.Database.php");
include($Configuration["LIBRARY_PATH"]."Utility.Class.SqlBuilder.php");
include($Configuration["LIBRARY_PATH"]."Utility.Class.MessageCollector.php");
include($Configuration["LIBRARY_PATH"]."Utility.Class.ErrorManager.php");
include($Configuration["LIBRARY_PATH"]."Utility.Class.ObjectFactory.php");
include($Configuration["LIBRARY_PATH"]."Utility.Class.StringManipulator.php");
include($Configuration["LIBRARY_PATH"]."Utility.Class.Context.php");
include($Configuration["LIBRARY_PATH"]."Utility.Class.Delegation.php");
include($Configuration["LIBRARY_PATH"]."Utility.Class.Control.php");
include($Configuration["LIBRARY_PATH"]."People.Class.Session.php");
include($Configuration["LIBRARY_PATH"]."People.Class.User.php");

// INSTANTIATE THE CONTEXT OBJECT
// The context object handles the following:
// - Open a connection to the database
// - Create a user session (autologging in any user with valid cookie credentials)
// - Instantiate debug and warning collectors
// - Instantiate an error manager
// - Define global variables relative to the current context (SelfUrl
$Context = new Context($Configuration);

// Set the ObjectFactory's reference for the authentication module
$Context->ObjectFactory->SetReference("Authenticator", $Configuration["AUTHENTICATION_MODULE"]);

// Start the session management
$Context->StartSession();

// DEFINE THE LANGUAGE DICTIONARY
include($Configuration["APPLICATION_PATH"]."conf/language.php");

// INSTANTIATE THE PAGE OBJECT
// The page object handles collecting all page controls
// and writing them when it's events are fired.
$Page = $Context->ObjectFactory->NewContextObject($Context, "Page", $Configuration["PAGE_EVENTS"]);

// FIRE INITIALIZATION EVENT
$Page->FireEvent("Page_Init");

// DEFINE THE MASTER PAGE CONTROLS
$Head = $Context->ObjectFactory->CreateControl($Context, "Head");
$PeopleMenu = $Context->ObjectFactory->CreateControl($Context, "PeopleMenu");
$Foot = $Context->ObjectFactory->CreateControl($Context, "PeopleFoot");
$PageEnd = $Context->ObjectFactory->CreateControl($Context, "PageEnd");

// INCLUDE EXTENSIONS
include($Configuration["APPLICATION_PATH"]."conf/extensions.php");

// BUILD THE PAGE HEAD
// Every page will require some basic definitions for the header.
$Head->AddScript("./js/global.js");
$Head->AddStyleSheet($Context->StyleUrl."css/signin.css", "screen");
$Head->AddStyleSheet($Context->StyleUrl."css/signin.handheld.css", "handheld");
?>