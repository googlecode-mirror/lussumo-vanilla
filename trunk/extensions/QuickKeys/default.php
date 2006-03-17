<?php
/*
Extension Name: Quick Keys
Extension Url: http://lussumo.com/docs/
Description: Allows users to use ALT+[KeyCode] to access various pages of Vanilla.
Version: 1.0
Author: Mark O'Sullivan
Author Url: http://www.markosullivan.ca/

Copyright 2003 - 2005 Mark O'Sullivan
This file is part of Vanilla.
Vanilla is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; either version 2 of the License, or (at your option) any later version.
Vanilla is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.
You should have received a copy of the GNU General Public License along with Vanilla; if not, write to the Free Software Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
The latest source code for Vanilla is available at www.lussumo.com
Contact Mark O'Sullivan at mark [at] lussumo [dot] com

You should cut & paste these language definitions into your
conf/your_language.php file (replace "your_language" with your chosen language,
of course):
*/
$Context->Dictionary["MenuOptions"] = "Menu Options";
$Context->Dictionary["UseQuickKeys"] = "Use quick-keys to access common forum pages";
$Context->Dictionary["Discussions_QuickKey"] = "<em>D</em>iscussions";
$Context->Dictionary["Categories_QuickKey"] = "<em>C</em>ategories";
$Context->Dictionary["Search_QuickKey"] = "<em>S</em>earch";
$Context->Dictionary["Settings_QuickKey"] = "S<em>e</em>ttings";
$Context->Dictionary["Account_QuickKey"] = "<em>A</em>ccount";
$Context->Dictionary["StartANewDiscussion_Quickkey"] = "Start a <em>n</em>ew discussion";


if (in_array($Context->SelfUrl, array("account.php", "categories.php", "comments.php", "index.php", "post.php", "search.php", "settings.php")) && $Context->Session->UserID > 0) {
   if (@$Menu && @$Context->Session->User) {
      if ($Context->Session->User->Preference("UseQuickKeys")) {
         // Clear out existing tabs and put in the new quickkey tabs
         $Menu->ClearTabs();
         $Menu->AddTab($Context->GetDefinition("Discussions_QuickKey"), "discussions", GetUrl($Configuration, "index.php"), "accesskey=\"d\"");
         if ($Context->Configuration["USE_CATEGORIES"]) $Menu->AddTab($Context->GetDefinition("Categories_QuickKey"), GetUrl($Configuration, "categories.php"), GetUrl($Configuration, "categories.php"), "accesskey=\"c\"");
         $Menu->AddTab($Context->GetDefinition("Search_QuickKey"), "search", GetUrl($Configuration, "search.php"), "accesskey=\"s\"");

			// Make sure they should be seeing the settings tab
			$RequiredPermissions = array("PERMISSION_CHECK_FOR_UPDATES",
				"PERMISSION_APPROVE_APPLICANTS",
				"PERMISSION_MANAGE_REGISTRATION",
				"PERMISSION_ADD_ROLES",
				"PERMISSION_EDIT_ROLES",
				"PERMISSION_REMOVE_ROLES",
				"PERMISSION_ADD_CATEGORIES",
				"PERMISSION_EDIT_CATEGORIES",
				"PERMISSION_REMOVE_CATEGORIES",
				"PERMISSION_SORT_CATEGORIES",
				"PERMISSION_CHANGE_APPLICATION_SETTINGS",
				"PERMISSION_MANAGE_EXTENSIONS",
				"PERMISSION_MANAGE_LANGUAGE",
				"PERMISSION_MANAGE_STYLES");
				
			$RequiredPermissionsCount = count($RequiredPermissions);
			for ($i = 0; $i < $RequiredPermissionsCount; $i++) {
				if ($Context->Session->User->Permission($RequiredPermissions[$i])) {
					$Menu->AddTab($Context->GetDefinition("Settings_QuickKey"), "settings", GetUrl($Configuration, "settings.php"), "accesskey=\"e\"");
					break;
				}
			}

         $Menu->AddTab($Context->GetDefinition("Account_QuickKey"), "account", GetUrl($Configuration, "account.php"), "accesskey=\"a\"");
         
         // Set up the "Start a new discussion" button
			$CategoryID = ForceIncomingInt("CategoryID", 0);
			if ($CategoryID == 0) $CategoryID = "";
         $StartANewDiscussionString = "<a class=\"PanelButton StartDiscussionButton\" href=\"".GetUrl($Configuration, "post.php", "category/", "CategoryID", $CategoryID)."\">".$Context->GetDefinition("StartANewDiscussion")."</a>";
			$StartButtonKey = array_search($StartANewDiscussionString, $Panel->Strings);
			if ($StartButtonKey !== false) {
				$Panel->Strings[$StartButtonKey] = "<a class=\"PanelButton StartDiscussionButton\" href=\"".GetUrl($Configuration, "post.php", "category/", "CategoryID", $CategoryID)."\" accesskey=\"n\">".$Context->GetDefinition("StartANewDiscussion_Quickkey")."</a>";
			}
      }
   }
}

// Add the QuickKeys setting to the forum preferences form
if ($Context->SelfUrl == "account.php" && $Context->Session->UserID > 0) {
	$PostBackAction = ForceIncomingString("PostBackAction", "");
	if ($PostBackAction == "Functionality") {
		function PreferencesForm_AddQuickKeysPreference(&$PreferencesForm) {
			$PreferencesForm->AddPreference("MenuOptions", "UseQuickKeys", "UseQuickKeys", 1);
		}
		
		$Context->AddToDelegate("PreferencesForm",
			"Constructor",
			"PreferencesForm_AddQuickKeysPreference");
	}
}

?>