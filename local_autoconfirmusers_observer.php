<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * @package local_autoconfirmusers
 * @author Andrew Hancox <andrewdchancox@googlemail.com>
 * @author Open Source Learning <enquiries@opensourcelearning.co.uk>
 * @link https://opensourcelearning.co.uk
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright 2021, Andrew Hancox
 */

use core\event\user_created;

class local_autoconfirmusers_observer {
    public static function autoconfirmuseraccount(user_created $event) {
        $authplugin = signup_get_user_confirmation_authplugin();
        if (!$authplugin) {
            return true;
        }
        if (empty(get_config('local_autoconfirmusers', 'enable'))) {
            return true;
        }
        $user = get_complete_user_data('id', $event->relateduserid);
        if (!empty($user->confirmed)) {
            return true;
        }
        return $authplugin->user_confirm($user->username, $user->secret);
    }
}
