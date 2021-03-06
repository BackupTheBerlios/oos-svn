<?php
/* ----------------------------------------------------------------------
   $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2009 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   File: MyOOS_CoreApi.class Revision: 17691
   ----------------------------------------------------------------------
   Gallery - a web based photo album viewer and editor
   http://gallery.menalto.com/

   Copyright (C) 2000-2008 Bharat Mediratta
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */

/** ensure this file is being included by a parent file */
defined( 'OOS_VALID_MOD' ) or die( 'Direct Access to this location is not allowed.' );


/*
 * Gallery - a web based photo album viewer and editor
 * Copyright (C) 2000-2008 Bharat Mediratta
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or (at
 * your option) any later version.
 *
 * This program is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street - Fifth Floor, Boston, MA  02110-1301, USA.
 */

/**
 * This is the unified API for Gallery 2.
 *
 * @package GalleryCore
 * @subpackage Classes
 * @author Bharat Mediratta <bharat@menalto.com>
 * @version Revision: 17691
 * @static
 */
class MyOOS_CoreApi {

    /**
     * Return the major and minor version of the Core API.
     *
     * When we add to the API, we'll bump the minor version.  When we change or remove something
     * from the API we'll change the major version.
     *
     * When writing a module, you should verify:
     * o The major version of the API exactly matches the version you expect
     * o The minor number is the same, or higher than the version you expect
     *
     * Notes:
     * o If the major number is lower, or it's the same and the minor number is
     *   lower then it means that the API is older than you require.
     * o If the major number is higher, then it means that the API is newer, but
     *   has made a change that may be incompatible with your module
     * o If the major number is the same and the minor number is higher, then
     *   the API has more features than you need but should still work for you.
     *
     * @return array major number, minor number
     *
     * @todo for next major version bump:
     * - remove GalleryUrlGenerator::getGalleryId
     * - remove GalleryStatus::wrap
     * - change MyOOS_CoreApi::error to only take error code and error message
     * - remove GalleryCapabilities (major bump of embed api too?)
     * - remove 'link' entry in Gallery.class constructor
     * - remove MyOOS_CoreApi::isPluginInDefaultLocation();
     * - remove support for check[Sidebar|Album|Photo]Blocks deprecated params
     *   for ShouldShowEmergencyEditItemLink in Callbacks.inc
     *   and comment in blocks/EmergencyEditItemLink.tpl
     * - remove GalleryView::_getItem() (the private version of getItem());
     * - remove support for : separator in GalleryView::loadView
     * - delete GallerySqlFragment.class
     * - remove studyPermissions, fetchPermissionsForItems does the same and more.
     * - remove MyOOS_Utilities::utf8Substring (moved to MyOOS_CoreApi)
     * - remove lib/wz_dragdrop/ (currently used by G2.1's watermark module)
     * - refactor renderer code (methods: getRenderer and render, GalleryEntity vs GalleryItem)
     * - remove support for {modules,themes}/.../locale dirs from lib/tools/po scripts
     *   from GalleryTranslatorHelper_medium::installTranslationsForPlugin,
     *   and from getPackageNames() in lib/tools/repository/classes/RepositoryDescriptor.class
     * - remove resourceGetTemplateBaseDir from GalleryTemplate class
     * - loadEntitiesById and deleteEntityById: make optional $requiredEntityType mandatory
     *   and other code marked for removal in helpers/GalleryEventHelper_simple.class
     * - consider renaming everything using "languageCode" to "locale" for correct terminology
     *   (GalleryTranslator.class and Gallery.class)
     * - delete modules/core/templates/blocks/NavigationLinks.tpl
     * - convert the contents of GALLERY_PERMISSION_SESSION_KEY to array indices instead of array
     *   of values.
     */
    function getApiVersion() {
        return array(2, 1);
    }

    /**
     * Register a new implementation with the factory
     *
     * @param string $classType the class type (eg. 'GalleryToolkit')
     * @param string $className the class name (eg. 'NetPbmToolkit')
     * @param string $implId an implementation id (eg. 'NetPBM')
     * @param string $implPath the relative path to the implementation file
     *               (eg. 'modules/netpbm/classes/NetPbmToolkit.class')
     * @param string $implModuleId the id of the module containing the implementation (eg. 'netpbm')
     * @param array $hints optional hints that can be used to locate this
     *              implementation (eg. array('image/jpeg', 'image/gif'))
     * @param int $orderWeight the priority of this implementation (lower number == higher priority)
     */
    function registerFactoryImplementation($classType, $className, $implId, $implPath,
                       $implModuleId, $hints, $orderWeight=5) {
    MyOOS_CoreApi::requireOnce(
        'modules/core/classes/helpers/GalleryFactoryHelper_medium.class');
    return GalleryFactoryHelper_medium::registerImplementation(
        $classType, $className, $implId, $implPath, $implModuleId, $hints, $orderWeight);
    }

    /**
     * Register a new implementation with the factory for this request only
     *
     * @param string $classType the class type (eg. 'GalleryToolkit')
     * @param string $className the class name (eg. 'NetPbmToolkit')
     * @param string $implId an implementation id (eg. 'NetPBM')
     * @param string $implPath the relative path to the implementation file
     *               (eg. 'modules/netpbm/classes/NetPbmToolkit.class')
     * @param string $implModuleId the id of the module containing the implementation (eg. 'netpbm')
     * @param array $hints optional hints that can be used to locate this
     *              implementation (eg. array('image/jpeg', 'image/gif'))
     * @return GalleryStatus
     */
    function registerFactoryImplementationForRequest($classType, $className, $implId, $implPath,
                          $implModuleId, $hints) {
    MyOOS_CoreApi::requireOnce(
        'modules/core/classes/helpers/GalleryFactoryHelper_medium.class');
    return GalleryFactoryHelper_medium::registerFactoryImplementationForRequest(
        $classType, $className, $implId, $implPath, $implModuleId, $hints);
    }

    /**
     * Create a new instance of the given type based on the hint(s) provided
     *
     * @param string $classType the class type (eg. 'GalleryToolkit')
     * @param mixed $hints array of hints to try (in order) or single string hint (eg. 'image/jpeg')
     * @return array GalleryStatus a status code,
     *               object an instance
     */
    function newFactoryInstanceByHint($classType, $hints) {
    MyOOS_CoreApi::requireOnce(
        'modules/core/classes/helpers/GalleryFactoryHelper_simple.class');
    return GalleryFactoryHelper_simple::newInstanceByHint($classType, $hints);
    }

    /**
     * Create a new instance of the given type
     *
     * @param string $classType the class type (eg. 'GalleryToolkit')
     * @param string $className the class name (eg. 'NetPbmToolkit')
     * @return GalleryStatus a status code
     *         object the instance
     */
    function newFactoryInstance($classType, $className=null) {
    MyOOS_CoreApi::requireOnce(
        'modules/core/classes/helpers/GalleryFactoryHelper_simple.class');
    return GalleryFactoryHelper_simple::newInstance($classType, $className);
    }

    /**
     * Create a new instance of the given type based on the id provided
     *
     * @param string $classType the class type (eg. 'GalleryToolkit')
     * @param string $id the class name (eg. 'NetPBM')
     * @return array GalleryStatus a status code,
     *               object an instance
     */
    function newFactoryInstanceById($classType, $id) {
    MyOOS_CoreApi::requireOnce(
        'modules/core/classes/helpers/GalleryFactoryHelper_simple.class');
    return GalleryFactoryHelper_simple::newInstanceById($classType, $id);
    }

    /**
     * Return the ids and class names of all the available implementations for a class
     *
     * @param string $classType the class type (eg. 'GalleryToolkit')
     * @return array GalleryStatus a status code
     *               array (id => className, ...)
     */
    function getAllFactoryImplementationIds($classType) {
    MyOOS_CoreApi::requireOnce(
        'modules/core/classes/helpers/GalleryFactoryHelper_simple.class');
    return GalleryFactoryHelper_simple::getAllImplementationIds($classType);
    }

    /**
     * Return the ids of all the available implementations for a class for a given hint.
     *
     * @return array GalleryStatus a status code
     *               array (id => className, ...)
     */
    function getAllFactoryImplementationIdsWithHint($classType, $hint) {
    MyOOS_CoreApi::requireOnce(
        'modules/core/classes/helpers/GalleryFactoryHelper_medium.class');
    return GalleryFactoryHelper_medium::getAllImplementationIdsWithHint($classType, $hint);
    }

    /**
     * Return the Hints for the specified class type and implId.
     *
     * @param string $classType Class type of the factory
     * @parma string $implId the implementation id of interest
     * @return array GalleryStatus
     *               array Hints for the specified implementation id and class type
     */
    function getFactoryDefinitionHints($classType, $implId) {
    MyOOS_CoreApi::requireOnce(
        'modules/core/classes/helpers/GalleryFactoryHelper_medium.class');
    return GalleryFactoryHelper_medium::getFactoryDefinitionHints($classType, $implId);
    }

    /**
     * Return the Hints for the specified class type and implId.
     *
     * @param string $classType Class type of the factory
     * @parma string $implId the implementation id of interest
     * @param mixed $hints array of hints to try (in order) or single string hint (eg. 'image/jpeg')
     * @return GalleryStatus
     */
    function updateFactoryDefinitionHints($classType, $implId, $hints) {
    MyOOS_CoreApi::requireOnce(
        'modules/core/classes/helpers/GalleryFactoryHelper_medium.class');
    return
        GalleryFactoryHelper_medium::updateFactoryDefinitionHints($classType, $implId, $hints);
    }

    /**
     * Unregister all factory implementations for a module
     *
     * @param string $moduleId an id (eg. 'netpbm')
     * @return GalleryStatus a status code
     */
    function unregisterFactoryImplementationsByModuleId($moduleId) {
    MyOOS_CoreApi::requireOnce(
        'modules/core/classes/helpers/GalleryFactoryHelper_medium.class');
    return GalleryFactoryHelper_medium::unregisterImplementationsByModuleId($moduleId);
    }

    /**
     * Unregister a factory implementation by id
     *
     * @param string $classType a class type (eg. 'GalleryToolkit')
     * @param string $implId an implementation id (eg. 'NetPBM')
     * @return GalleryStatus a status code
     */
    function unregisterFactoryImplementation($classType, $implId) {
    MyOOS_CoreApi::requireOnce(
        'modules/core/classes/helpers/GalleryFactoryHelper_medium.class');
    return GalleryFactoryHelper_medium::unregisterImplementation($classType, $implId);
    }

    /**
     * Load and initialize the given plugin
     *
     * @param string $pluginType the plugin type (eg. module, theme)
     * @param string $pluginId the plugin id
     * @param bool $ignoreVersionMismatch should we ignore version mismatches (default: no)
     * @param bool $errorOnVersionMismatch should we return an error on version mismatches instead
     *             of redirecting to the upgrader?  (default: false)
     * @return array GalleryStatus a status code
     *               object the plugin
     */
    function loadPlugin($pluginType, $pluginId, $ignoreVersionMismatch=false,
            $errorOnVersionMismatch=false) {
    MyOOS_CoreApi::requireOnce(
        'modules/core/classes/helpers/GalleryPluginHelper_simple.class');
    return GalleryPluginHelper_simple::loadPlugin(
        $pluginType, $pluginId, $ignoreVersionMismatch, $errorOnVersionMismatch);
    }

    /**
     * Return true if the plugin is compatible with the current API versions.  False otherwise.
     *
     * @param GalleryPlugin $plugin
     * @return boolean true if the plugin is compatible
     */
    function isPluginCompatibleWithApis($plugin) {
    MyOOS_CoreApi::requireOnce(
        'modules/core/classes/helpers/GalleryPluginHelper_simple.class');
    return GalleryPluginHelper_simple::isPluginCompatibleWithApis($plugin);
    }

    /**
     * Convenience method to retrieve a plugin parameter
     *
     * @param string $pluginType
     * @param string $pluginId
     * @param string $parameterName
     * @param string $itemId (optional)
     * @return array GalleryStatus a status code
     *               string a value
     */
    function getPluginParameter($pluginType, $pluginId, $parameterName, $itemId=0) {
    MyOOS_CoreApi::requireOnce(
        'modules/core/classes/helpers/GalleryPluginHelper_simple.class');
    return GalleryPluginHelper_simple::getParameter($pluginType, $pluginId,
                            $parameterName, $itemId);
    }

    /**
     * Get all the parameters for this plugin
     *
     * @param string $pluginType
     * @param string $pluginId
     * @param int $itemId the id of item (or null for global settings)
     * @return array GalleryStatus a status code
     *               array (parameterName => parameterValue)
     */
    function fetchAllPluginParameters($pluginType, $pluginId, $itemId=0) {
    MyOOS_CoreApi::requireOnce(
        'modules/core/classes/helpers/GalleryPluginHelper_simple.class');
    return GalleryPluginHelper_simple::fetchAllParameters($pluginType, $pluginId, $itemId);
    }

    /**
     * Remove all plugin parameters for a given item id
     *
     * @param int $itemId the id of the GalleryItem
     * @return GalleryStatus a status code
     */
    function removePluginParametersForItemId($itemId) {
    MyOOS_CoreApi::requireOnce(
        'modules/core/classes/helpers/GalleryPluginHelper_medium.class');
    return GalleryPluginHelper_medium::removeParametersForItemId($itemId);
    }

    /**
     * Remove all plugin entries for a given parameter and value pair
     *
     * @param string $pluginType
     * @param string $pluginId
     * @param string $parameterName
     * @param mixed $parameterValue the value to be matched
     * @return GalleryStatus a status code
     */
    function removePluginParameterByValue($pluginType, $pluginId, $parameterName, $parameterValue) {
    MyOOS_CoreApi::requireOnce(
        'modules/core/classes/helpers/GalleryPluginHelper_medium.class');
    return GalleryPluginHelper_medium::removeParameterByValue($pluginType, $pluginId,
                                  $parameterName, $parameterValue);
    }

    /**
     * Get the status of all plugins of a given type
     *
     * Notes:
     *   - Some array elements are empty for uninstalled plugins
     *     ('version', 'required*Api', 'callbacks').
     *   - Installed but unavailable plugins are not listed.
     *
     * @param string $pluginType
     * @param bool $ignoreCache (optional) true if we want to ignore the cache
     * @return array GalleryStatus as status code
     *                      array (moduleId => array('active' => true/false,
     *                                               'available' => true/false,
     *                             'callbacks' => string,
     *                             'requiredCoreApi' => array
     *                             'requiredModuleApi' => array,
     *                             'version' => string)
     */
    function fetchPluginStatus($pluginType, $ignoreCache=false) {
    MyOOS_CoreApi::requireOnce(
        'modules/core/classes/helpers/GalleryPluginHelper_simple.class');
    return GalleryPluginHelper_simple::fetchPluginStatus($pluginType, $ignoreCache);
    }

    /**
     * Return a plugin list by plugin type of all installed plugins.
     *
     * @param string $pluginType
     * @return array GalleryStatus a status code
     *               array of (pluginId => ('active' => boolean))
     */
    function fetchPluginList($pluginType) {
    MyOOS_CoreApi::requireOnce(
        'modules/core/classes/helpers/GalleryPluginHelper_simple.class');
    return GalleryPluginHelper_simple::fetchPluginList($pluginType);
    }

    /**
     * Activate the given plugin
     *
     * @param string $pluginType
     * @param string $pluginId
     * @return array GalleryStatus a status code
     *               array redirect info for error page (empty for success)
     */
    function activatePlugin($pluginType, $pluginId) {
    MyOOS_CoreApi::requireOnce(
        'modules/core/classes/helpers/GalleryPluginHelper_medium.class');
    return GalleryPluginHelper_medium::activate($pluginType, $pluginId);
    }

    /**
     * Deactivate the given plugin
     *
     * @param string $pluginType
     * @param string $pluginId
     * @return array GalleryStatus a status code
     *               array redirect info for error page (empty for success)
     */
    function deactivatePlugin($pluginType, $pluginId) {
    MyOOS_CoreApi::requireOnce(
        'modules/core/classes/helpers/GalleryPluginHelper_medium.class');
    return GalleryPluginHelper_medium::deactivate($pluginType, $pluginId);
    }

    /**
     * Remove the given plugin from the map
     *
     * @param string $pluginType
     * @param string $pluginId
     * @return GalleryStatus a status code
     */
    function removePlugin($pluginType, $pluginId) {
    MyOOS_CoreApi::requireOnce(
        'modules/core/classes/helpers/GalleryPluginHelper_medium.class');
    return GalleryPluginHelper_medium::removePlugin($pluginType, $pluginId);
    }

    /**
     * Get the list of all available plugins of a given type
     *
     * @param string $pluginType
     * @return array GalleryStatus a status code
     *               string plugin ids
     */
    function getAllPluginIds($pluginType) {
    MyOOS_CoreApi::requireOnce(
        'modules/core/classes/helpers/GalleryPluginHelper_medium.class');
    return GalleryPluginHelper_medium::getAllPluginIds($pluginType);
    }

    /**
     * Remove a parameter for this plugin
     *
     * @param string $pluginType
     * @param string $pluginId
     * @param string $parameterName
     * @param int $itemId the id of item (or null for a global setting)
     * @return GalleryStatus a status code
     */
    function removePluginParameter($pluginType, $pluginId, $parameterName, $itemId=0) {
    MyOOS_CoreApi::requireOnce(
        'modules/core/classes/helpers/GalleryPluginHelper_medium.class');
    return GalleryPluginHelper_medium::removeParameter($pluginType, $pluginId,
                               $parameterName, $itemId);
    }

    /**
     * Remove all parameters for this plugin
     *
     * @param string $pluginType
     * @param string $pluginId
     * @return GalleryStatus a status code
     */
    function removeAllPluginParameters($pluginType, $pluginId) {
    MyOOS_CoreApi::requireOnce(
        'modules/core/classes/helpers/GalleryPluginHelper_medium.class');
    return GalleryPluginHelper_medium::removeAllParameters($pluginType, $pluginId);
    }

    /**
     * Set a plugin parameter
     *
     * @param string $pluginType
     * @param string $pluginId
     * @param string $parameterName
     * @param string $parameterValue
     * @param string $itemId (optional)
     * @return GalleryStatus a status code
     */
    function setPluginParameter($pluginType, $pluginId, $parameterName,
                $parameterValue, $itemId=0) {
    MyOOS_CoreApi::requireOnce(
        'modules/core/classes/helpers/GalleryPluginHelper_medium.class');
    return GalleryPluginHelper_medium::setParameter($pluginType, $pluginId,
                            $parameterName, $parameterValue, $itemId);
    }

    /**
     * Fetch all the access list ids that grant the given permission to the given user
     * (either directly or via a group).
     *
     * @param string|array $permission a single permission id (eg. 'core.view')
     *                                 or an array of permission ids
     * @param int $userId
     * @param boolean $sessionPermissions (optional) false to ignore session based permissions
     * @return array GalleryStatus a status code
     *               array int access list ids
     */
    function fetchAccessListIds($permission, $userId, $sessionPermissions=true) {
    MyOOS_CoreApi::requireOnce(
        'modules/core/classes/helpers/GalleryPermissionHelper_simple.class');
    return GalleryPermissionHelper_simple::fetchAccessListIds(
        $permission, $userId, $sessionPermissions);
    }

    /**
     * Compact the access list map, if we deem that it's a good time to do so.
     *
     * @return GalleryStatus a status code
     */
    function maybeCompactAccessLists() {
    MyOOS_CoreApi::requireOnce(
        'modules/core/classes/helpers/GalleryPermissionHelper_advanced.class');
    return GalleryPermissionHelper_advanced::maybeCompactAccessLists();
    }

    /**
     * Compact the access map.  Remove any duplicate access maps and remap any subscribers from
     * the duplicates to the one remaining version.
     *
     * @return GalleryStatus a status code
     */
    function compactAccessLists() {
    MyOOS_CoreApi::requireOnce(
        'modules/core/classes/helpers/GalleryPermissionHelper_advanced.class');
    return GalleryPermissionHelper_advanced::compactAccessLists();
    }

    /**
     * Look up an item's access list.
     *
     * @param int $itemId the id of the source item
     * @return array GalleryStatus a status code,
     *               int accessListId the associated item's list
     */
    function fetchAccessListId($itemId) {
    MyOOS_CoreApi::requireOnce(
        'modules/core/classes/helpers/GalleryPermissionHelper_advanced.class');
    return GalleryPermissionHelper_advanced::fetchAccessListId($itemId);
    }

    /**
     * Assert that the current user has the specific permission for the target item
     *
     * @param int $itemId
     * @param string $permission
     * @return GalleryStatus success if the user has permission,
     *                              ERROR_PERMISSION_DENIED if not.
     */
    function assertHasItemPermission($itemId, $permission) {
    MyOOS_CoreApi::requireOnce('modules/core/classes/helpers/GalleryUserHelper_simple.class');
    return GalleryUserHelper_simple::assertHasItemPermission($itemId, $permission);
    }

    /**
     * Return true if the current user has the specific permission for the target item
     *
     * @param int $itemId
     * @param string $permission
     * @param int $userId an optional user id (default is the current user)
     * @param boolean $sessionPermissions (optional) false to ignore session based permissions
     * @return array GalleryStatus a status code
     *               boolean true if yes
     */
    function hasItemPermission($itemId, $permission, $userId=null, $sessionPermissions=true) {
    MyOOS_CoreApi::requireOnce('modules/core/classes/helpers/GalleryUserHelper_simple.class');
    return GalleryUserHelper_simple::hasItemPermission(
        $itemId, $permission, $userId, $sessionPermissions);
    }

    /**
     * Return a map of userNames => userids
     *
     * You can specify how many users to list, and where the windows is in the list of all users.
     *
     * @param int $count (optional) the number of usernames desired
     * @param int $offset (optional) the start of the range
     * @param string $substring (optional) a substring to match
     * @return array GalleryStatus a status code
     *               array (username, username, ...)
     */
    function fetchUsernames($count=null, $offset=null, $substring=null) {
    MyOOS_CoreApi::requireOnce('modules/core/classes/helpers/GalleryUserHelper_medium.class');
    return GalleryUserHelper_medium::fetchUsernames($count, $offset, $substring);
    }

    /**
     * Return the total number of users
     *
     * @param string $substring an optional substring to match against the username
     * @return array GalleryStatus a status code
     *               int number of users
     */
    function fetchUserCount($substring=null, $groupId=null) {
    MyOOS_CoreApi::requireOnce('modules/core/classes/helpers/GalleryUserHelper_medium.class');
    return GalleryUserHelper_medium::fetchUserCount($substring, $groupId);
    }

    /**
     * Lookup a user by username
     *
     * @param string $userName
     * @return array GalleryStatus a status code
     *               GalleryUser a user
     */
    function fetchUserByUserName($userName=null) {
    MyOOS_CoreApi::requireOnce('modules/core/classes/helpers/GalleryUserHelper_medium.class');
    return GalleryUserHelper_medium::fetchUserByUserName($userName);
    }

    /**
     * Assert that the active user is a site administrator
     *
     * @return GalleryStatus success if the user is an administrator
     *                              ERROR_PERMISSION_DENIED if not.
     */
    function assertUserIsSiteAdministrator() {
    MyOOS_CoreApi::requireOnce('modules/core/classes/helpers/GalleryUserHelper_medium.class');
    return GalleryUserHelper_medium::assertSiteAdministrator();
    }

    /**
     * Delete all non-album items of a user. Then delete all remaining albums that are empty.
     * This function can only be called with activeUser = Site Admin
     *
     * @param int $userId
     * @return array GalleryStatus a status code
     */
    function deleteUserItems($userId) {
    MyOOS_CoreApi::requireOnce('modules/core/classes/helpers/GalleryUserHelper_medium.class');
    return GalleryUserHelper_medium::deleteUserItems($userId);
    }

    /**
     * Use the given operation as a transform for each derivative that depends on the target
     * derivative.  This gives the dependent derivatives a chance to perform any necessary
     * transformations required to adapt to an upstream derivative operation change.  For example,
     * if you have a preferred which has a dependent thumbnail which has a crop operation in it,
     * then you "rotate|90" the preferred you'd call adjustDependentDerivatives on the thumbnail
     * with the "rotate|90" operation so that we can rotate the crop coordinates appropriately.
     *
     * @param array $id id the target derivative
     * @param string $operation the operation that was performed on the target derivative
     * @param boolean $reverse (optional) true if we should apply the transform in reverse
     * @return GalleryStatus a status code
     */
    function adjustDependentDerivatives($id, $operation, $reverse=false) {
    MyOOS_CoreApi::requireOnce(
        'modules/core/classes/helpers/GalleryDerivativeHelper_advanced.class');
    return GalleryDerivativeHelper_advanced::adjustDependentDerivatives($id, $operation,
                                        $reverse);
    }

    /**
     * Use the given operation as a transform for each derivative that depends on the target
     *
     * @param string $operation the operation to be executed
     * @param array $args arguments of the operation
     * @param boolean $preserveOriginal whether to preserve original
     * @param GalleryItem $args item to perform the operation on
     * @param GalleryDerivative (optional) preferred derivative to execute the operation on
     * @param int $serialNumber (optional) avoid concurrent edits
     * @return GalleryStatus a status code
     */
    function applyToolkitOperation($operation, $args, $preserveOriginal,
                   &$item, $preferred=null, $serialNumber=null) {
    MyOOS_CoreApi::requireOnce(
        'modules/core/classes/helpers/GalleryDerivativeHelper_advanced.class');
    return GalleryDerivativeHelper_advanced::applyToolkitOperation($operation,
                $args, $preserveOriginal, $item, $preferred, $serialNumber);
    }

    /**
     * Find all derivatives attached to one source and switch them to another one
     *
     * @param string $originalSourceId the original source id
     * @param string $newSourceId the new source id
     * @return GalleryStatus a status code
     */
    function remapSourceIds($originalSourceId, $newSourceId) {
    MyOOS_CoreApi::requireOnce(
        'modules/core/classes/helpers/GalleryDerivativeHelper_advanced.class');
    return GalleryDerivativeHelper_advanced::remapSourceIds($originalSourceId, $newSourceId);
    }

    /**
     * Copy the derivative preferences from one id to another.
     * Note that this doesn't modify pre-existing preferences already assigned to the target.
     *
     * @param int $sourceId the source id
     * @param int $targetId the target id
     * @return GalleryStatus a status code
     */
    function copyDerivativePreferences($sourceId, $targetId) {
    MyOOS_CoreApi::requireOnce(
        'modules/core/classes/helpers/GalleryDerivativeHelper_advanced.class');
    return GalleryDerivativeHelper_advanced::copyPreferences($sourceId, $targetId);
    }

    /**
     * Get the derivative preferences for the given item
     *
     * @param int $targetId the target id
     * @return array GalleryStatus a status code
     *               array (derivativeType => ..., derivativeOperations => ...)
     */
    function fetchDerivativePreferencesForItem($targetId) {
    MyOOS_CoreApi::requireOnce(
        'modules/core/classes/helpers/GalleryDerivativeHelper_advanced.class');
    return GalleryDerivativeHelper_advanced::fetchPreferencesForItem($targetId);
    }

    /**
     * Add a derivative preference to a given item
     *
     * @param int $order the position of this preference
     * @param int $itemId
     * @param int $derivativeType (eg. DERIVATIVE_TYPE_IMAGE_THUMBNAIL)
     * @param string $derivativeOperations (eg. 'thumbnail|200')
     * @return GalleryStatus a status code
     */
    function addDerivativePreference($order, $itemId, $derivativeType, $derivativeOperations) {
    MyOOS_CoreApi::requireOnce(
        'modules/core/classes/helpers/GalleryDerivativeHelper_advanced.class');
    return GalleryDerivativeHelper_advanced::addPreference($order, $itemId, $derivativeType,
                                   $derivativeOperations);
    }

    /**
     * Remove derivative preference for a given item/type combination
     *
     * @param int $itemId
     * @param int $derivativeType
     * @return GalleryStatus a status code
     */
    function removeDerivativePreferenceForItemType($itemId, $derivativeType) {
    MyOOS_CoreApi::requireOnce(
        'modules/core/classes/helpers/GalleryDerivativeHelper_advanced.class');
    return GalleryDerivativeHelper_advanced::removePreferenceForItemType($itemId,
                                         $derivativeType);
    }

    /**
     * Remove all derivative preferences for a given item
     *
     * @param int $itemId
     * @return GalleryStatus a status code
     */
    function removeDerivativePreferencesForItem($itemId) {
    MyOOS_CoreApi::requireOnce(
        'modules/core/classes/helpers/GalleryDerivativeHelper_advanced.class');
    return GalleryDerivativeHelper_advanced::removePreferencesForItem($itemId);
    }

    /**
     * Estimate the dimensions of a GalleryDerivativeImage from its operations and its source.
     * @todo This method knows too much about a small set of operations.  We should move it into
     *       the toolkits themselves.
     *
     * @param GalleryDerivativeImage $derivative
     * @param GalleryDerivativeEntity $source
     *               (probably a GalleryPhotoItem or GalleryMovieItem)
     * @return GalleryStatus a status code
     */
    function estimateDerivativeDimensions(&$derivative, $source) {
    MyOOS_CoreApi::requireOnce(
        'modules/core/classes/helpers/GalleryToolkitHelper_medium.class');
    return GalleryToolkitHelper_medium::estimateDerivativeDimensions($derivative, $source);
    }

    /**
     * Set modification timestamp for the given entity id to the current time.
     *
     * @param int $entityId
     * @return GalleryStatus a status code
     */
    function updateModificationTimestamp($entityId) {
    MyOOS_CoreApi::requireOnce(
        'modules/core/classes/helpers/GalleryEntityHelper_medium.class');
    return GalleryEntityHelper_medium::updateModificationTimestamp($entityId);
    }

    /**
     * Update the view count for this item id
     * @param int $itemId
     * @param int $step the amount to increment
     * @return GalleryStatus a status code
     */
    function incrementItemViewCount($itemId, $step=1) {
    MyOOS_CoreApi::requireOnce(
        'modules/core/classes/helpers/GalleryItemAttributesHelper_simple.class');
    return GalleryItemAttributesHelper_simple::incrementViewCount($itemId, $step);
    }

    /**
     * Create a new set of attributes for an item
     * @param int $itemId
     * @param array $parentSequence the sequence of parent ids
     * @return GalleryStatus a status code
     */
    function createItemAttributes($itemId, $parentSequence) {
    MyOOS_CoreApi::requireOnce(
        'modules/core/classes/helpers/GalleryItemAttributesHelper_advanced.class');
    return GalleryItemAttributesHelper_advanced::createItemAttributes($itemId, $parentSequence);
    }

    /**
     * Remove the attributes for the given item
     * @param int $itemId
     * @return GalleryStatus a status code
     */
    function removeItemAttributes($itemId) {
    MyOOS_CoreApi::requireOnce(
        'modules/core/classes/helpers/GalleryItemAttributesHelper_advanced.class');
    return GalleryItemAttributesHelper_advanced::removeItemAttributes($itemId);
    }

    /**
     * Update the view count for this item id
     * @param int $itemId
     * @param int $count the new count
     * @return GalleryStatus a status code
     */
    function setItemViewCount($itemId, $count) {
    MyOOS_CoreApi::requireOnce(
        'modules/core/classes/helpers/GalleryItemAttributesHelper_advanced.class');
    return GalleryItemAttributesHelper_advanced::setViewCount($itemId, $count);
    }

    /**
     * Get the view counts for many item ids
     * @param int $itemId
     * @return array GalleryStatus a status code
     *               int view count
     */
    function fetchItemViewCount($itemId) {
    MyOOS_CoreApi::requireOnce(
        'modules/core/classes/helpers/GalleryItemAttributesHelper_simple.class');
    return GalleryItemAttributesHelper_simple::fetchViewCount($itemId);
    }

    /**
     * Get the view counts for many item ids
     * @param array $itemIds
     * @return array GalleryStatus a status code
     *               array (itemId => viewCount, ..)
     */
    function fetchItemViewCounts($itemIds) {
    MyOOS_CoreApi::requireOnce(
        'modules/core/classes/helpers/GalleryItemAttributesHelper_simple.class');
    return GalleryItemAttributesHelper_simple::fetchViewCounts($itemIds);
    }

    /**
     * Set the order weight for an item id
     * @param int $itemId
     * @param int $orderWeight the new order weight
     * @return GalleryStatus a status code
     */
    function setItemOrderWeight($itemId, $orderWeight) {
    MyOOS_CoreApi::requireOnce(
        'modules/core/classes/helpers/GalleryItemAttributesHelper_advanced.class');
    return GalleryItemAttributesHelper_advanced::setOrderWeight($itemId, $orderWeight);
    }

    /**
     * Get the order weight for a given item id
     * @param int $itemId
     * @return array GalleryStatus a status code
     *               int the order weight
     */
    function fetchItemOrderWeight($itemId) {
    MyOOS_CoreApi::requireOnce(
        'modules/core/classes/helpers/GalleryItemAttributesHelper_medium.class');
    return GalleryItemAttributesHelper_medium::fetchOrderWeight($itemId);
    }

    /**
     * Get the order weight for many item ids
     * @param array $itemIds
     * @return array GalleryStatus a status code
     *               array(itemId1 => orderWeight1,
     *                     itemId2 => orderWeight2, ...)
     */
    function fetchItemOrderWeights($itemIds) {
    MyOOS_CoreApi::requireOnce(
        'modules/core/classes/helpers/GalleryItemAttributesHelper_medium.class');
    return GalleryItemAttributesHelper_medium::fetchOrderWeights($itemIds);
    }

    /**
     * Rebalance the order weights associated with this item's children.  When this method is
     * complete, the child item ids should still have the same order as they have now, but their
     * order weights should be spaced out to exactly the spacing value specified in the arguments.
     *
     * @param int $parentItemId
     * @param int $spacing the order spacing
     * @return GalleryStatus a status code
     */
    function rebalanceChildOrderWeights($parentItemId, $spacing=1000) {
    MyOOS_CoreApi::requireOnce(
        'modules/core/classes/helpers/GalleryItemAttributesHelper_advanced.class');
    return GalleryItemAttributesHelper_advanced::rebalanceChildOrderWeights($parentItemId,
                                        $spacing);
    }

    /**
     * Fetch the highest or lowest weight of all children
     * @param int $itemId the parent item id
     * @param int $direction the direction (HIGHER_WEIGHT, LOWER_WEIGHT)
     * @return int a weight
     */
    function fetchExtremeChildWeight($itemId, $direction) {
    MyOOS_CoreApi::requireOnce(
        'modules/core/classes/helpers/GalleryItemAttributesHelper_advanced.class');
    return GalleryItemAttributesHelper_advanced::fetchExtremeChildWeight($itemId, $direction);
    }

    /**
     * Fetch the weight of the next peer in line (higher or lower, as specified)
     *
     * @param int $itemId
     * @param int $direction the direction (HIGHER_WEIGHT, LOWER_WEIGHT)
     * @return int a weight
     */
    function fetchNextItemWeight($itemId, $direction) {
    MyOOS_CoreApi::requireOnce(
        'modules/core/classes/helpers/GalleryItemAttributesHelper_advanced.class');
    return GalleryItemAttributesHelper_advanced::fetchNextWeight($itemId, $direction);
    }

    /**
     * Set the parent id sequence for an item id
     *
     * @param int $itemId
     * @param array $parentSequence the parent sequence (ids)
     * @return GalleryStatus a status code
     */
    function setParentSequence($itemId, $parentSequence) {
    MyOOS_CoreApi::requireOnce(
        'modules/core/classes/helpers/GalleryItemAttributesHelper_advanced.class');
    return GalleryItemAttributesHelper_advanced::setParentSequence($itemId, $parentSequence);
    }

    /**
     * Update all items containing the source parent sequence to the new parent sequence
     *
     * @param array $oldParentSequence
     * @param array $newParentSequence the parent sequence (ids)
     * @return GalleryStatus a status code
     */
    function updateParentSequence($oldParentSequence, $newParentSequence) {
    MyOOS_CoreApi::requireOnce(
        'modules/core/classes/helpers/GalleryItemAttributesHelper_advanced.class');
    return GalleryItemAttributesHelper_advanced::updateParentSequence($oldParentSequence,
                                      $newParentSequence);
    }

    /**
     * Get the parent sequence for this item id
     * @param int $itemId
     * @param bool $filterBreadcrumb (optional) whether to filter results with breadcrumbRootId
     * @return array GalleryStatus a status code
     *               array the parent id sequence from root album down; given itemId not included
     */
    function fetchParentSequence($itemId, $filterBreadcrumb=false) {
    MyOOS_CoreApi::requireOnce(
        'modules/core/classes/helpers/GalleryItemAttributesHelper_simple.class');
    return GalleryItemAttributesHelper_simple::fetchParentSequence($itemId, $filterBreadcrumb);
    }

    /**
     * Return the correct theme for this item.  If the appropriate theme cannot be loaded,
     * we fall back on the default.  And if that can't be loaded, then we return null.
     *
     * @param GalleryItem $item
     * @return array GalleryStatus a status code
     *               string a theme plugi
     */
    function fetchThemeId($item) {
    MyOOS_CoreApi::requireOnce('modules/core/classes/helpers/GalleryItemHelper_simple.class');
    return GalleryItemHelper_simple::fetchThemeId($item);
    }

    /**
     * Return the number of children for the items specified, that are visible to the given user.
     *
     * @param array $itemIds
     * @param int $userId an optional user id (default is the current user)
     * @return array GalleryStatus a status code
     *               array (itemId => count, itemId => count, ...)
     */
    function fetchChildCounts($itemIds, $userId=null) {
    MyOOS_CoreApi::requireOnce('modules/core/classes/helpers/GalleryItemHelper_simple.class');
    return GalleryItemHelper_simple::fetchChildCounts($itemIds, $userId);
    }

    /**
     * Fetch the breakdown of descendents for a given item
     *
     * @param array $itemIds
     * @param int $userId an optional user id (default is the current user)
     * @return array GalleryStatus a status code
     *               array(id => ##, id => ##)
     */
    function fetchDescendentCounts($itemIds, $userId=null) {
    MyOOS_CoreApi::requireOnce('modules/core/classes/helpers/GalleryItemHelper_simple.class');
    return GalleryItemHelper_simple::fetchDescendentCounts($itemIds, $userId);
    }

    /**
     * Fetch the breakdown of descendents for a given item.  Note: this call is more expensive than
     * MyOOS_CoreApi::fetchDescendentCounts(), so use that version where possible.
     *
     * @param array $itemIds
     * @return array GalleryStatus a status code
     *               array(id => array('GalleryAlbumItem' => ##,
     *                                 'GalleryDataItem' => ##),
     *                     id => array('GalleryAlbumItem' => ##,
     *                                 'GalleryDataItem' => ##))
     */
    function fetchItemizedDescendentCounts($itemIds) {
    MyOOS_CoreApi::requireOnce(
        'modules/core/classes/helpers/GalleryItemHelper_advanced.class');
    return GalleryItemHelper_advanced::fetchItemizedDescendentCounts($itemIds);
    }

    /**
     * Return the number of of items that match the given type and have the given permission.
     *
     * @param string $itemType an item type (eg. GalleryAlbumItem)
     * @param string $permission (default is core.view)
     * @param int $userId an optional user id (default is the current user)
     * @return array GalleryStatus a status code
     *               int a count
     */
    function fetchItemIdCount($itemType, $permission='core.view', $userId=null) {
    MyOOS_CoreApi::requireOnce('modules/core/classes/helpers/GalleryItemHelper_simple.class');
    return GalleryItemHelper_simple::fetchItemIdCount($itemType, $permission, $userId);
    }

    /**
     * Return the ids of all the child items of the given item that have the matching permission.
     * Useful for, example, for finding all the children where we (the active user) has the
     * 'core.changePermissions' permission bit set.  This allows us to cascade permission updates.
     *
     * @param int $itemId
     * @param array|string $permissionId Either a single permission-id or an array of permission-ids
     * @return array GalleryStatus a status code
     *               array a list of ids
     */
    function fetchChildItemIdsWithPermission($itemId, $permissionId) {
    MyOOS_CoreApi::requireOnce(
        'modules/core/classes/helpers/GalleryChildEntityHelper_simple.class');
    return GalleryChildEntityHelper_simple::fetchChildItemIdsWithPermission($itemId,
                                        $permissionId);
    }

    /**
     * Return the ids of all the child items of the given item that have the matching permission
     * and are linkable entities.  Useful for, example, for finding all the children where we
     * (the active user) has the 'core.changePermissions' permission bit set.  This allows us to
     * cascade permission updates.
     *
     * @param array $itemId
     * @param array|string $permission (default is core.view). Either a single permission-id
     *                     or an array of permission-ids.
     * @return array GalleryStatus a status code
     *               array a list of ids
     */
    function fetchLinkableChildItemIdsWithPermission($itemId, $permissionId) {
    MyOOS_CoreApi::requireOnce(
        'modules/core/classes/helpers/GalleryChildEntityHelper_simple.class');
    return GalleryChildEntityHelper_simple::fetchLinkableChildItemIdsWithPermission($itemId,
                                            $permissionId);
    }

    /**
     * Return the ids of all items that match the given type and have the given permission.
     *
     * @param string $itemType an item type (eg. GalleryAlbumItem)
     * @param array|string $permission (default is core.view). Either a single permission-id
     *                     or an array of permission-ids.
     * @return array GalleryStatus a status code
     *               array(id, id, id, ...)
     */
    function fetchAllItemIds($itemType, $permission='core.view') {
    MyOOS_CoreApi::requireOnce('modules/core/classes/helpers/GalleryItemHelper_medium.class');
    return GalleryItemHelper_medium::fetchAllItemIds($itemType, $permission);
    }

    /**
     * Return the ids of all items which are owned by the given userid.
     * This function does NOT obey permissions!
     *
     * @param int $ownerId the id of the owner of the items
     * @return array GalleryStatus a status code
     *               array(id, id, id, ...)
     */
    function fetchAllItemIdsByOwnerId($ownerId) {
    MyOOS_CoreApi::requireOnce('modules/core/classes/helpers/GalleryItemHelper_medium.class');
    return GalleryItemHelper_medium::fetchAllItemIdsByOwnerId($ownerId);
    }

    /**
     * Return the appropriate GalleryItem instance for the mime type provided.
     * Use the GalleryFactory to try to find an exact match to the mime type.
     * Failing that, fall back to the major type, then fall back to '*'.
     *
     * @param string $mimeType
     * @return array GalleryStatus a status code
     *               GalleryItem an item
     */
    function newItemByMimeType($mimeType) {
    MyOOS_CoreApi::requireOnce('modules/core/classes/helpers/GalleryItemHelper_medium.class');
    return GalleryItemHelper_medium::newItemByMimeType($mimeType);
    }

    /**
     * Create a new album.
     *
     * @param int $parentAlbumId the id of the parent album
     * @param string $name the name of the new album
     * @param string $title the title of the new album
     * @param string $summary the summary of the new album
     * @param string $description the description of the new album
     * @param string $keywords the keywords of the new album
     * @return array GalleryStatus a status code
     *               GalleryAlbumItem a new album
     */
    function createAlbum($parentAlbumId, $name, $title, $summary, $description, $keywords) {
    MyOOS_CoreApi::requireOnce(
        'modules/core/classes/helpers/GalleryItemHelper_advanced.class');
    return GalleryItemHelper_advanced::createAlbum($parentAlbumId, $name, $title, $summary,
                               $description, $keywords);
    }

    /**
     * Add a new data item to an album from a data file.
     *
     * @param string $fileName the path to the file on the local disk
     * @param string $itemName the name of the new item
     * @param string $title the title of the new item
     * @param string $summary the summary of the new item
     * @param string $description the description of the new item
     * @param string $mimeType the mime type of the new item
     * @param int $albumId the id of the target album
     * @param boolean $symlink (optional) a boolean true if we should symlink instead
     *        of copy (default is false).
     * @return array GalleryStatus a status code
     *               GalleryDataItem a new item
     */
    function addItemToAlbum($fileName, $itemName, $title, $summary,
                $description, $mimeType, $albumId, $symlink=false) {
    MyOOS_CoreApi::requireOnce('modules/core/classes/helpers/GalleryItemHelper_medium.class');
    return GalleryItemHelper_medium::addItemToAlbum(
        $fileName, $itemName, $title, $summary, $description, $mimeType, $albumId, $symlink);
    }

    /**
     * Add an existing data item to an album
     *
     * @param GalleryItem $item the source item
     * @param int $albumId the id of the target album
     * @param boolean $isNew (optional) if true, skip check for existing derivatives
     * @return GalleryStatus a status code
     */
    function addExistingItemToAlbum($item, $albumId, $isNew=false) {
    MyOOS_CoreApi::requireOnce('modules/core/classes/helpers/GalleryItemHelper_medium.class');
    return GalleryItemHelper_medium::addExistingItemToAlbum($item, $albumId, $isNew);
    }

    /**
     * (Re)create derivatives for a data item according to preferences for given album
     *
     * @param GalleryItem $item the source item
     * @param int $albumId the id of the target album
     * @param boolean $isNew (optional) if true, skip check for existing derivatives
     * @return GalleryStatus a status code
     */
    function applyDerivativePreferences($item, $albumId, $isNew=false) {
    MyOOS_CoreApi::requireOnce('modules/core/classes/helpers/GalleryItemHelper_medium.class');
    return GalleryItemHelper_medium::applyDerivativePreferences($item, $albumId, $isNew);
    }

    /**
     * Fetch the originationTimestamp through our known toolkits
     *
     * @param GalleryItem $item
     * @return array GalleryStatus a status code
     *               int a timestamp or null if nothing was found
     */
    function fetchOriginationTimestamp($item) {
    MyOOS_CoreApi::requireOnce('modules/core/classes/helpers/GalleryItemHelper_medium.class');
    return GalleryItemHelper_medium::fetchOriginationTimestamp($item);
    }

    /**
     * Set the thumbnail for an album from an item, according to the thumbnail
     * preferences for the album.
     *
     * @param int $itemId the album id
     * @param int $fromItemId the item id
     * @return GalleryStatus a status code
     *                boolean true if successful
     */
    function setThumbnailFromItem($itemId, $fromItemId) {
    MyOOS_CoreApi::requireOnce('modules/core/classes/helpers/GalleryItemHelper_medium.class');
    return GalleryItemHelper_medium::setThumbnailFromItem($itemId, $fromItemId);
    }

    /**
     * Make sure that the album has a thumbnail.  If it doesn't, then grab the first handy child and
     * make it the album's thumbnail.  We're not picky.
     *
     * @param int $itemId the album id
     * @return GalleryStatus a status code
     *                boolean true if successful
     */
    function guaranteeAlbumHasThumbnail($itemId) {
    MyOOS_CoreApi::requireOnce(
        'modules/core/classes/helpers/GalleryItemHelper_advanced.class');
    return GalleryItemHelper_advanced::guaranteeAlbumHasThumbnail($itemId);
    }

    /**
     * Fetch album tree visible to current user,
     * optionally starting from a given album and to a given depth.
     *
     * @param int $itemId (optional) id of album for root of tree
     * @param int $depth (optional) max depth of tree
     * @param int $userId (optional) items visible to this user id, instead of current user
     * @return array GalleryStatus a status code
     *               array (albumId => array(albumId => array, ..), ..)
     */
    function fetchAlbumTree($itemId=null, $depth=null, $userId=null) {
    MyOOS_CoreApi::requireOnce(
        'modules/core/classes/helpers/GalleryItemHelper_simple.class');
    return GalleryItemHelper_simple::fetchAlbumTree($itemId, $depth, $userId);
    }

    /**
     * Transfer the ownership of all items by oldUser to newUser
     *
     * @param int $oldUserId the user id of the old owner
     * @param int $newUserId the user id of the new owner
     * @return GalleryStatus a status code
     */
    function remapOwnerId($oldUserId, $newUserId) {
    MyOOS_CoreApi::requireOnce(
        'modules/core/classes/helpers/GalleryItemHelper_advanced.class');
    return GalleryItemHelper_advanced::remapOwnerId($oldUserId, $newUserId);
    }

    /**
     * Is the active user in the admin group?
     *
     * @param int $userId an optional user id (default is the current user)
     * @return array GalleryStatus a status code
     *               boolean true if yes
     */
    function isUserInSiteAdminGroup($userId=null) {
    MyOOS_CoreApi::requireOnce(
        'modules/core/classes/helpers/GalleryUserGroupHelper_simple.class');
    return GalleryUserGroupHelper_simple::isUserInSiteAdminGroup($userId);
    }

    /**
     * Is the given user id in the given group?
     *
     * @param int $userId
     * @param int $groupId
     * @return array GalleryStatus a status code
     *               boolean true if yes
     */
    function isUserInGroup($userId, $groupId) {
    MyOOS_CoreApi::requireOnce(
        'modules/core/classes/helpers/GalleryUserGroupHelper_simple.class');
    return GalleryUserGroupHelper_simple::isUserInGroup($userId, $groupId);
    }

    /**
     * Add the specified user to the specified group.
     *
     * @param int $userId
     * @param int $groupId
     * @return GalleryStatus a status code
     */
    function addUserToGroup($userId, $groupId) {
    MyOOS_CoreApi::requireOnce(
        'modules/core/classes/helpers/GalleryUserGroupHelper_medium.class');
    return GalleryUserGroupHelper_medium::addUserToGroup($userId, $groupId);
    }

    /**
     * Remove the specified user to the specified group.
     *
     * @param int $userId
     * @param int $groupId
     * @return GalleryStatus a status code
     */
    function removeUserFromGroup($userId, $groupId) {
    MyOOS_CoreApi::requireOnce(
        'modules/core/classes/helpers/GalleryUserGroupHelper_medium.class');
    return GalleryUserGroupHelper_medium::removeUserFromGroup($userId, $groupId);
    }

    /**
     * Remove the user from all groups
     *
     * @param int $userId
     * @return GalleryStatus a status code
     */
    function removeUserFromAllGroups($userId) {
    MyOOS_CoreApi::requireOnce(
        'modules/core/classes/helpers/GalleryUserGroupHelper_medium.class');
    return GalleryUserGroupHelper_medium::removeUserFromAllGroups($userId);
    }

    /**
     * Remove any users in the group
     *
     * @param int $groupId
     * @return GalleryStatus a status code
     */
    function removeAllUsersFromGroup($groupId) {
    MyOOS_CoreApi::requireOnce(
        'modules/core/classes/helpers/GalleryUserGroupHelper_medium.class');
    return GalleryUserGroupHelper_medium::removeAllUsersFromGroup($groupId);
    }

    /**
     * Return a list of user ids belonging to a group
     *
     * You can specify how many userids to list, and where the windows is in
     * the list of all users.
     *
     * @param int $groupId
     * @param int $count the number of user ids desired
     * @param int $offset the start of the range
     * @param string $substring substring to match against the username
     * @return array GalleryStatus a status code
     *               array user id => user name
     */
    function fetchUsersForGroup($groupId, $count=null, $offset=null, $substring=null) {
    MyOOS_CoreApi::requireOnce(
        'modules/core/classes/helpers/GalleryUserGroupHelper_medium.class');
    return GalleryUserGroupHelper_medium::fetchUsersForGroup($groupId, $count,
                                 $offset, $substring);
    }

    /**
     * Return a list of groups that a user belongs to.
     * You can specify how many userids to list, and where the windows is in the list of all users.
     *
     * @param int $userId
     * @param int $count the number of group ids desired
     * @param int $offset the start of the range
     * @return array GalleryStatus a status code
     *               array group id => group name
     */
    function fetchGroupsForUser($userId, $count=null, $offset=null) {
    MyOOS_CoreApi::requireOnce(
        'modules/core/classes/helpers/GalleryUserGroupHelper_simple.class');
    return GalleryUserGroupHelper_simple::fetchGroupsForUser($userId, $count, $offset);
    }

    /**
     * Fetch the preferred language of a specific user.
     *
     * @param int $userId
     * @return array GalleryStatus a status code
     *               string code of preferred locale
     */
    function fetchLanguageCodeForUser($userId) {
    MyOOS_CoreApi::requireOnce('modules/core/classes/helpers/GalleryUserHelper_medium.class');
    return GalleryUserHelper_medium::fetchLanguageCodeForUser($userId);
    }

    /**
     * Given a complete logical path, return the item id that it refers to.
     *
     * @param string $path
     * @return array GalleryStatus a status code
     *               int the item id
     */
    function fetchItemIdByPath($path) {
    MyOOS_CoreApi::requireOnce(
        'modules/core/classes/helpers/GalleryFileSystemEntityHelper_simple.class');
    return GalleryFileSystemEntityHelper_simple::fetchItemIdByPath($path);
    }

    /**
     * Check for a collision of FileSystemEntiry paths.
     *
     * @param string $pathComponent
     * @param int $parentId the id of the target parent
     * @param int $selfId (optional) ignore path collision with this id
     * @return array GalleryStatus a status code
     *               boolean true if there's a collision
     */
    function checkPathCollision($pathComponent, $parentId, $selfId=null) {
    MyOOS_CoreApi::requireOnce(
        'modules/core/classes/helpers/GalleryFileSystemEntityHelper_medium.class');
    return GalleryFileSystemEntityHelper_medium::checkPathCollision($pathComponent,
                                    $parentId, $selfId);
    }

    /**
     * Get a legal path component in the given parent id.  Legal by the platform standards, and
     * legal in that it doesn't cause a conflict with other path components.
     *
     * @param string $pathComponent the starting path component (eg. "IMG_10293.JPG")
     * @param int $parentId the target parent id
     * @param int $selfId (optional) ignore path collision with this id
     * @param boolean $forDirectory (optional) Whether the path component is for a directory.
     *        Defaults to false. Periods are allowed anywhere in directories.
     * @return array GalleryStatus a status code
     *               string the legal path component
     */
    function getLegalPathComponent($pathComponent, $parentId, $selfId=null, $forDirectory=false) {
    MyOOS_CoreApi::requireOnce(
        'modules/core/classes/helpers/GalleryFileSystemEntityHelper_medium.class');
    return GalleryFileSystemEntityHelper_medium::getLegalPathComponent(
                        $pathComponent, $parentId, $selfId, $forDirectory);
    }

    /**
     * Returns the id of the child filesystem entity that matches the given path component.
     * Note: this call ignores permissions so it must be used very carefully!
     *
     * @param int $parentId
     * @param string $pathComponent of the target item
     * @return array GalleryStatus a status code
     *               int an id
     */
    function fetchChildIdByPathComponent($parentId, $pathComponent) {
    MyOOS_CoreApi::requireOnce(
        'modules/core/classes/helpers/GalleryFileSystemEntityHelper_simple.class');
    return GalleryFileSystemEntityHelper_simple::fetchChildIdByPathComponent($parentId,
                                         $pathComponent);
    }

    /**
     * Register the operations that a toolkit is able to perform on a certain mime type.
     *
     * This should be called by a module that provides a toolkit to access certain mime types.
     * The module should also call MyOOS_CoreApi::registerFactoryImplementation with the same
     * "id" that it registers here, so the correct class can be found later.
     *
     * @param string $toolkitId the id of the toolkit
     * @param array $mimeTypes the applicable mime types for this operation
     * @param string $operationName the id of the operation
     * @param array $parameterTypesArray a list of parameters that this operation requires
     * @param string $description a translatable description of this operation
     * @param string $outputMimeType the output mime type after performing this operation
     * @param int $priority priority of this implementation vs other toolkits
     * @return GalleryStatus a status code
     */
    function registerToolkitOperation($toolkitId, $mimeTypes, $operationName,
                      $parameterTypesArray, $description,
                      $outputMimeType='', $priority=5) {
    MyOOS_CoreApi::requireOnce(
        'modules/core/classes/helpers/GalleryToolkitHelper_medium.class');
    return GalleryToolkitHelper_medium::registerOperation(
        $toolkitId, $mimeTypes, $operationName, $parameterTypesArray, $description,
        $outputMimeType, $priority);
    }

    /**
     * Unregister an operation that a toolkit is able to perform on certain mime types
     *
     * @param string $toolkitId the id of the toolkit
     * @param string $operationName the id of the operation
     * @param array $mimeTypes the applicable mime types to remove; empty for all mime types
     * @return GalleryStatus a status code
     */
    function unregisterToolkitOperation($toolkitId, $operationName, $mimeTypes=array()) {
    MyOOS_CoreApi::requireOnce(
        'modules/core/classes/helpers/GalleryToolkitHelper_medium.class');
    return GalleryToolkitHelper_medium::unregisterOperation($toolkitId, $operationName,
                                $mimeTypes);
    }

    /**
     * Unregister all operations and properties for toolkits implemented by the given module.
     *
     * @param string $moduleId
     * @return GalleryStatus a status code
     */
    function unregisterToolkitsByModuleId($moduleId) {
    MyOOS_CoreApi::requireOnce(
        'modules/core/classes/helpers/GalleryToolkitHelper_medium.class');
    return GalleryToolkitHelper_medium::unregisterToolkitsByModuleId($moduleId);
    }

    /**
     * Register a parameter that a toolkit can extract from a certain mime type.
     *
     * This should be called by a module that provides a toolkit to access certain mime types.
     * The module should also call MyOOS_CoreApi::registerFactoryImplementation with the same
     * "id" that it registers here, so the correct class can be found later.
     *
     * @param string $toolkitId the id of the toolkit
     * @param array $mimeTypes the applicable mime types for this property
     * @param string $propertyName the name of the property
     * @param string $type the type of the property
     * @param string $description a translatable description of this property
     * @return GalleryStatus a status code
     */
    function registerToolkitProperty($toolkitId, $mimeTypes, $propertyName, $type, $description) {
    MyOOS_CoreApi::requireOnce(
        'modules/core/classes/helpers/GalleryToolkitHelper_medium.class');
    return GalleryToolkitHelper_medium::registerProperty($toolkitId, $mimeTypes,
                                 $propertyName, $type, $description);
    }

    /**
     * Unregister a toolkit's operations and properties.  If we have any remaining that are no
     * longer implemented by any toolkit then remove them from the system also.
     *
     * @param string $toolkitId
     * @return GalleryStatus a status code
     */
    function unregisterToolkit($toolkitId) {
    MyOOS_CoreApi::requireOnce(
        'modules/core/classes/helpers/GalleryToolkitHelper_medium.class');
    return GalleryToolkitHelper_medium::unregisterToolkit($toolkitId);
    }

    /**
     * Get all valid operations on a certain mime type
     *
     * @param string $mimeType
     * @return array GalleryStatus a status code
     *               array('name' => ...,
     *                     'outputMimeType' => ...,
     *                     'description' => ...,
     *                     arguments => array('type' => ...,
     *                                        'description' => ...),
     *                                  ...)
     */
    function getToolkitOperations($mimeType) {
    MyOOS_CoreApi::requireOnce(
        'modules/core/classes/helpers/GalleryToolkitHelper_medium.class');
    return GalleryToolkitHelper_medium::getOperations($mimeType);
    }

    /**
     * Get all valid input mime types for a certain operation
     *
     * @param string $operationName
     * @return array GalleryStatus a status code
     *               array(mime type => array(toolkit ids, sorted by priority))
     */
    function getToolkitOperationMimeTypes($operationName) {
    MyOOS_CoreApi::requireOnce(
        'modules/core/classes/helpers/GalleryToolkitHelper_medium.class');
    return GalleryToolkitHelper_medium::getOperationMimeTypes($operationName);
    }

    /**
     * Get all valid properties of a certain mime type
     *
     * @param string $mimeType
     * @return array GalleryStatus a status code
     *               array (
     *                  array('name' => property, 'type' => type, 'description' => description), ..
     *               )
     *
     */
    function getToolkitProperties($mimeType) {
    MyOOS_CoreApi::requireOnce(
        'modules/core/classes/helpers/GalleryToolkitHelper_medium.class');
    return GalleryToolkitHelper_medium::getProperties($mimeType);
    }

    /**
     * Get a toolkit that can perform the given operation
     *
     * @param string $mimeType
     * @param string $operationName
     * @return array GalleryStatus a status code
     *               GalleryToolkit a toolkit
     *               string a result mime type
     */
    function getToolkitByOperation($mimeType, $operationName) {
    MyOOS_CoreApi::requireOnce(
        'modules/core/classes/helpers/GalleryToolkitHelper_simple.class');
    return GalleryToolkitHelper_simple::getToolkitByOperation($mimeType, $operationName);
    }

    /**
     * Verify that a given mime-type/operation-sequence combination is supported by our existing
     * toolkits by walking the sequence and making sure that we have a toolkit that can handle
     * each operation.
     *
     * @param string $mimeType the original mime type
     * @param string $operations a sequence of operations
     * @return GalleryStatus a status code
     *         boolean true if supported, false if not
     *         string the output mime type
     */
    function isSupportedOperationSequence($mimeType, $operations) {
    MyOOS_CoreApi::requireOnce(
        'modules/core/classes/helpers/GalleryToolkitHelper_medium.class');
    return GalleryToolkitHelper_medium::isSupportedOperationSequence($mimeType, $operations);
    }

    /**
     * Make sure operation sequence is supported and produces a browser-viewable output mime type.
     * Add convert-to-image/jpeg operation if needed.
     *
     * @param string $mimeType the original mime type
     * @param string $operations a sequence of operations
     * @param boolean $prependConversion (optional) true to also try prepending convert-to-image/xxx
     * @return array GalleryStatus a status code
     *               string a sequence of operations, null if not supported
     *               string the output mime type, null if not supported
     */
    function makeSupportedViewableOperationSequence($mimeType, $operations,
                            $prependConversion=true) {
    MyOOS_CoreApi::requireOnce(
        'modules/core/classes/helpers/GalleryToolkitHelper_medium.class');
    return GalleryToolkitHelper_medium::makeSupportedViewableOperationSequence(
        $mimeType, $operations, $prependConversion);
    }

    /**
     * Get a toolkit that can retrieve the given property
     *
     * @param string $mimeType
     * @param string $propertyName
     * @return array GalleryStatus a status code
     *               GalleryToolkit a toolkit
     */
    function getToolkitByProperty($mimeType, $propertyName) {
    MyOOS_CoreApi::requireOnce(
        'modules/core/classes/helpers/GalleryToolkitHelper_simple.class');
    return GalleryToolkitHelper_simple::getToolkitByProperty($mimeType, $propertyName);
    }

    /**
     * Get the toolkits that can retrieve the given property
     *
     * @param string $mimeType
     * @param string $propertyName
     * @return array GalleryStatus a status code
     *               array of toolkitIds
     */
    function getToolkitsByProperty($mimeType, $propertyName) {
    MyOOS_CoreApi::requireOnce(
        'modules/core/classes/helpers/GalleryToolkitHelper_simple.class');
    return GalleryToolkitHelper_simple::getToolkitsByProperty($mimeType, $propertyName);
    }

    /**
     * Get maximum priority value (lowest priority) in managed priority range (20-40)
     *
     * @return array GalleryStatus a status code
     *               int priority
     */
    function getMaximumManagedToolkitPriority() {
    MyOOS_CoreApi::requireOnce(
        'modules/core/classes/helpers/GalleryToolkitHelper_simple.class');
    return GalleryToolkitHelper_simple::getMaximumManagedPriority();
    }

    /**
     * Get maximum priority value (lowest priority) in managed priority range (20-40)
     *
     * @param string $toolkitId
     * @return array GalleryStatus a status code
     *               int priority
     */
    function getToolkitPriorityById($toolkitId) {
    MyOOS_CoreApi::requireOnce(
        'modules/core/classes/helpers/GalleryToolkitHelper_simple.class');
    return GalleryToolkitHelper_simple::getToolkitPriorityById($toolkitId);
    }


    /**
     * Get list of toolkits/priorities in managed priority range (20-40) for which
     * another toolkit supports a same operation and mime type.
     *
     * @return array GalleryStatus a status code
     *               array (toolkitId=>priority, ..)
     */
    function getRedundantToolkitPriorities() {
    MyOOS_CoreApi::requireOnce(
        'modules/core/classes/helpers/GalleryToolkitHelper_medium.class');
    return GalleryToolkitHelper_medium::getRedundantPriorities();
    }

    /**
     * Create a new event with the given name.
     * @param string $eventName the name of the event, e.g. GalleryEntity::save
     * @return GalleryEvent an event with the given name
     */
    function newEvent($eventName) {
    MyOOS_CoreApi::requireOnce('modules/core/classes/helpers/GalleryEventHelper_simple.class');
    return GalleryEventHelper_simple::newEvent($eventName);
    }


    /**
     * Deliver an event to anybody listening.
     * @param GalleryEvent $event
     * @return array GalleryStatus a status code
     *               array data returned from listeners, if any
     */
    function postEvent($event) {
    MyOOS_CoreApi::requireOnce('modules/core/classes/helpers/GalleryEventHelper_simple.class');
    return GalleryEventHelper_simple::postEvent($event);
    }


    /**
     * Read Lock one or more objects
     *
     * @param mixed $ids array of ids to lock, or single int id
     * @param int $timeout (optional) how long to wait for the lock before giving up
     * @return array GalleryStatus a status code
     *               int the lock id
     */
    function acquireReadLock($ids, $timeout=10) {
    MyOOS_CoreApi::requireOnce('modules/core/classes/helpers/GalleryLockHelper_simple.class');
    return GalleryLockHelper_simple::acquireReadLock($ids, $timeout);
    }

    /**
     * Acquire read locks on all the ancestors of this id.  This is useful when we're going to do
     * a filesystem related operation and we want to make sure that the tree does not change out
     * from underneath us.
     *
     * @param int $id
     * @param int $timeout (optional) how long to wait for the lock before giving up
     * @return array GalleryStatus a status code
     *               int the lock id
     */
    function acquireReadLockParents($id, $timeout=10) {
    MyOOS_CoreApi::requireOnce('modules/core/classes/helpers/GalleryLockHelper_simple.class');
    return GalleryLockHelper_simple::acquireReadLockParents($id, $timeout);
    }

    /**
     * Return true if the given id is read locked or write locked by us.
     *
     * @param int $id an entity id
     * @return boolean true if the entity is read locked
     */
    function isReadLocked($id) {
    MyOOS_CoreApi::requireOnce('modules/core/classes/helpers/GalleryLockHelper_simple.class');
    return GalleryLockHelper_simple::isReadLocked($id);
    }

    /**
     * Write lock one or more objects
     *
     * @param mixed $ids array of ids to lock, or single int id
     * @param int $timeout (optional) how long to wait for the lock before giving up
     * @return array GalleryStatus a status code
     *               int the lock id
     */
    function acquireWriteLock($ids, $timeout=10) {
    MyOOS_CoreApi::requireOnce('modules/core/classes/helpers/GalleryLockHelper_simple.class');
    return GalleryLockHelper_simple::acquireWriteLock($ids, $timeout);
    }

    /**
     * Return true if the given id is write locked by us.
     *
     * @param int $id an entity id
     * @return boolean true if the entity is write locked
     */
    function isWriteLocked($id) {
    MyOOS_CoreApi::requireOnce('modules/core/classes/helpers/GalleryLockHelper_simple.class');
    return GalleryLockHelper_simple::isWriteLocked($id);
    }

    /**
     * Release the given lock(s)
     *
     * @param mixed $lockIds array of lock ids, or a single lock id
     * @return GalleryStatus a status code
     */
    function releaseLocks($lockIds) {
    MyOOS_CoreApi::requireOnce('modules/core/classes/helpers/GalleryLockHelper_simple.class');
    return GalleryLockHelper_simple::releaseLocks($lockIds);
    }

    /**
     * Let go of all of our locks.
     *
     * @return GalleryStatus a status code
     */
    function releaseAllLocks() {
    MyOOS_CoreApi::requireOnce('modules/core/classes/helpers/GalleryLockHelper_simple.class');
    return GalleryLockHelper_simple::releaseAllLocks();
    }

    /**
     * Refresh all the locks that we hold so that they aren't accidentally considered expired
     *
     * @param int $freshUntil the new "fresh until" timestamp
     * @return GalleryStatus a status code
     */
    function refreshLocks($freshUntil) {
    MyOOS_CoreApi::requireOnce('modules/core/classes/helpers/GalleryLockHelper_simple.class');
    return GalleryLockHelper_simple::refreshLocks($freshUntil);
    }

    /**
     * Get the set of lock ids
     *
     * @return object array of lock ids
     */
    function getLockIds() {
    MyOOS_CoreApi::requireOnce('modules/core/classes/helpers/GalleryLockHelper_simple.class');
    return GalleryLockHelper_simple::getLockIds();
    }

    /**
     * Load the GalleryEntities with the ids specified
     *
     * @param mixed $ids the ids (or id) of the GalleryEntities to load
     * @param mixed $requiredEntityType (optional) Throw an ERROR_MISSING_OBJECT if the loaded
     *              entity doesn't extend the given entity-type (or types), e.g. 'GalleryItem'.
     *              Specify 'GalleryEntity' if any entity type is allowed.
     * @return array GalleryStatus a status code,
     *               mixed one GalleryEntity or an array of GalleryEntities
     * @deprecated $requiredEntityType will no longer be optional after the next major API change
     */
    function loadEntitiesById($ids, $requiredEntityType=null) {
    MyOOS_CoreApi::requireOnce(
        'modules/core/classes/helpers/GalleryEntityHelper_simple.class');
    return GalleryEntityHelper_simple::loadEntitiesById($ids, $requiredEntityType);
    }

    /**
     * Delete the entity with the given id
     *
     * @param int $id the id of a GalleryEntity to delete
     * @param mixed $requiredEntityType (optional) Throw an ERROR_MISSING_OBJECT if the loaded
     *               entity doesn't extend the given entity-type (or types).
     *               Specify 'GalleryEntity' if any entity type is allowed.
     * @return GalleryStatus a status code
     * @deprecated $requiredEntityType will no longer be optional after the next major API change
     */
    function deleteEntityById($id, $requiredEntityType=null) {
    MyOOS_CoreApi::requireOnce(
        'modules/core/classes/helpers/GalleryEntityHelper_medium.class');
    return GalleryEntityHelper_medium::deleteEntityById($id, $requiredEntityType);
    }

    /**
     * Fetch the ids of the entities linked to the target entity
     *
     * @param int $targetId the target entity id
     * @return array GalleryStatus a status code
     *               array entity ids
     */
    function fetchEntitiesLinkedTo($targetId) {
    MyOOS_CoreApi::requireOnce(
        'modules/core/classes/helpers/GalleryEntityHelper_medium.class');
    return GalleryEntityHelper_medium::fetchEntitiesLinkedTo($targetId);
    }

    /**
     * Map external id to G2 id and then load the entity
     *
     * @param string $externalId
     * @param string $entityType
     * @return array GalleryStatus a status code
     *               GalleryEntity
     */
    function loadEntityByExternalId($externalId, $entityType) {
    MyOOS_CoreApi::requireOnce(
        'modules/core/classes/helpers/GalleryEntityHelper_simple.class');
    return GalleryEntityHelper_simple::loadEntityByExternalId($externalId, $entityType);
    }

    /**
     * Remove onLoadHandlers from all entities
     *
     * @param array $handlerIds of factory impl ids
     * @return GalleryStatus a status code
     */
    function removeOnLoadHandlers($handlerIds) {
    MyOOS_CoreApi::requireOnce(
        'modules/core/classes/helpers/GalleryEntityHelper_medium.class');
    return GalleryEntityHelper_medium::removeOnLoadHandlers($handlerIds);
    }

    /**
     * Return the ids of the descendents of this entity that are visible to the given user.
     *
     * @param GalleryItem $item
     * @param int $offset where to start
     * @param int $count how many to return
     * @param string $permission (optional) what permission is required for the item
     * @return array GalleryStatus a status code
     *               array integer ids
     */
    function fetchDescendentItemIds($item, $offset=null, $count=null, $permission='core.view') {
    MyOOS_CoreApi::requireOnce(
        'modules/core/classes/helpers/GalleryChildEntityHelper_simple.class');
    return GalleryChildEntityHelper_simple::fetchDescendentItemIds($item, $offset,
                                       $count, $permission);
    }

    /**
     * Return the ids of the children of this entity, in the order specified by the orderBy field
     * and the direction specified by the orderDirection field, that are visible to the given user.
     *
     * @param GalleryItem $item
     * @param int $offset where to start
     * @param int $count how many to return
     * @param int $userId optional user id.  Defaults to current user id
     * @return array GalleryStatus a status code
     *               array integer ids
     */
    function fetchChildItemIds($item, $offset=null, $count=null, $userId=null) {
    MyOOS_CoreApi::requireOnce(
        'modules/core/classes/helpers/GalleryChildEntityHelper_simple.class');
    return GalleryChildEntityHelper_simple::fetchChildItemIds($item, $offset, $count, $userId);
    }

    /**
     * Same as fetchDescendentItemIds except we only want sub-albums
     *
     * @param GalleryItem $item
     * @param int $offset where to start
     * @param int $count how many to return
     * @param string $permission (optional) what permission is required for the item
     * @return array GalleryStatus a status code
     *               array integer ids
     */
    function fetchDescendentAlbumItemIds($item, $offset=null, $count=null,
                     $permission='core.view') {
    MyOOS_CoreApi::requireOnce(
        'modules/core/classes/helpers/GalleryChildEntityHelper_simple.class');
    return GalleryChildEntityHelper_simple::fetchDescendentAlbumItemIds($item, $offset,
                                        $count, $permission);
    }

    /**
     * Same as fetchChildItemIds except we only want sub-albums
     *
     * @param GalleryItem $item
     * @param int $offset where to start
     * @param int $count how many to return
     * @param int $userId optional user id.  Defaults to current user id
     * @return array GalleryStatus a status code
     *               array integer ids
     */
    function fetchChildAlbumItemIds($item, $offset=null, $count=null, $userId=null) {
    MyOOS_CoreApi::requireOnce(
        'modules/core/classes/helpers/GalleryChildEntityHelper_simple.class');
    return GalleryChildEntityHelper_simple::fetchChildAlbumItemIds($item, $offset,
                                       $count, $userId);
    }

    /**
     * Same as fetchChildItemIds except we only want data items
     *
     * @param GalleryItem $item
     * @param int $offset where to start
     * @param int $count how many to return
     * @param int $userId optional user id.  Defaults to current user id
     * @return array GalleryStatus a status code
     *               array integer ids
     */
    function fetchChildDataItemIds($item, $offset=null, $count=null, $userId=null) {
    MyOOS_CoreApi::requireOnce(
        'modules/core/classes/helpers/GalleryChildEntityHelper_simple.class');
    return GalleryChildEntityHelper_simple::fetchChildDataItemIds($item, $offset,
                                      $count, $userId);
    }

    /**
     * Same as fetchChildItemIds, except that we ignore permissions
     *
     * @param GalleryItem $item
     * @param int $offset where to start
     * @param int $count how many to return
     * @return array GalleryStatus a status code
     *               array integer ids
     */
    function fetchChildItemIdsIgnorePermissions($item, $offset=null, $count=null) {
    MyOOS_CoreApi::requireOnce(
        'modules/core/classes/helpers/GalleryChildEntityHelper_simple.class');
    return GalleryChildEntityHelper_simple::fetchChildItemIdsIgnorePermissions($item, $offset,
                                           $count);
    }

    /**
     * Load all the ancestors of this item
     *
     * @param GalleryItem $item
     * @param string|array $permission (optional) only return ancestors with a specific permission
     *                                            or an array of required permissions
     * @param bool $filterBreadcrumb (optional) whether to filter results with breadcrumbRootId
     * @return array GalleryStatus a status code
     *               array of GalleryItem, from top level to parent item
     */
    function fetchParents($item, $permission=null, $filterBreadcrumb=false) {
    MyOOS_CoreApi::requireOnce(
        'modules/core/classes/helpers/GalleryChildEntityHelper_simple.class');
    return GalleryChildEntityHelper_simple::fetchParents($item, $permission, $filterBreadcrumb);
    }

    /**
     * Build query to select items in a given sort order
     *
     * @param string $baseTable base table to query
     * @param string $baseIdColumn name of id column in this table
     * @param string $baseQuery where clause for query
     * @param string $orderBy order for results
     * @param string $orderDirection order direction for results
     * @param string $class a class to restrict children to (eg. 'GalleryAlbumItem'; can be null)
     * @param string|array $requiredPermission a single required permission (can be null)
     *                                         or an array of required permission-ids
     * @param boolean $linkableOnly whether to restrict to linkable items only
     * @param int $userId the user we're doing this for
     * @return array GalleryStatus a status code
     *               string query
     *               array data items for query (not including any ? marks in baseQuery)
     */
    function buildItemQuery($baseTable, $baseIdColumn, $baseQuery, $orderBy, $orderDirection,
                $class, $requiredPermission, $linkableOnly, $userId) {
    MyOOS_CoreApi::requireOnce(
        'modules/core/classes/helpers/GalleryChildEntityHelper_simple.class');
    return GalleryChildEntityHelper_simple::buildItemQuery($baseTable, $baseIdColumn,
        $baseQuery, $orderBy, $orderDirection, $class, $requiredPermission,
        $linkableOnly, $userId);
    }

    /**
     * Convert a file extension to a mime type
     *
     * @param string $extension a file extension
     * @return array GalleryStatus a status code
     *               string a mime type (application/unknown if no known mapping)
     */
    function convertExtensionToMime($extension) {
    MyOOS_CoreApi::requireOnce(
        'modules/core/classes/helpers/GalleryMimeTypeHelper_simple.class');
    return GalleryMimeTypeHelper_simple::convertExtensionToMime($extension);
    }

    /**
     * Convert a mime type to a file extension
     *
     * @param string $mimeType
     * @return array GalleryStatus a status code
     *               array of file extensions (empty array if no known mapping)
     */
    function convertMimeToExtensions($mimeType) {
    MyOOS_CoreApi::requireOnce(
        'modules/core/classes/helpers/GalleryMimeTypeHelper_simple.class');
    return GalleryMimeTypeHelper_simple::convertMimeToExtensions($mimeType);
    }

    /**
     * Determine the proper mime type given the file and optionally with the mime type
     * from the request
     *
     * @param string $filename the file name to determine the mime type for
     * @param string $requestMimeType (optional)
     * @return array GalleryStatus a status code
     *               string a mime type (application/unknown if no known extension)
     */
    function getMimeType($filename, $requestMimeType=null) {
    MyOOS_CoreApi::requireOnce(
        'modules/core/classes/helpers/GalleryMimeTypeHelper_simple.class');
    return GalleryMimeTypeHelper_simple::getMimeType($filename, $requestMimeType);
    }

    /**
     * Return true if the given mime type is viewble in a web browser
     *
     * @param string $mimeType
     * @return array GalleryStatus a status code
     *               boolean
     */
    function isViewableMimeType($mimeType) {
    MyOOS_CoreApi::requireOnce(
        'modules/core/classes/helpers/GalleryMimeTypeHelper_simple.class');
    return GalleryMimeTypeHelper_simple::isViewableMimeType($mimeType);
    }

    /**
     * Remove specified mime data from the list.
     * examples: array('mimeType' => 'test/image') or array('extension' => array('img', 'im2'))
     *
     * @param array $mimeMatch (keys/values to delete)
     * @return GalleryStatus a status code
     */
    function removeMimeType($mimeMatch) {
    MyOOS_CoreApi::requireOnce(
        'modules/core/classes/helpers/GalleryMimeTypeHelper_advanced.class');
    return GalleryMimeTypeHelper_advanced::removeMimeType($mimeMatch);
    }


    /**
     * Add the given extension to the database and map it to the specified mime type and mark it
     * viewable as requested.  Return ERROR_COLLISION if there's already a mapping for the given
     * extension.
     *
     * @param string $extension
     * @param string $mimeType
     * @param bool $viewable whether or not it's browser viewable
     * @return GalleryStatus a status code
     */
    function addMimeType($extension, $mimeType, $viewable) {
    MyOOS_CoreApi::requireOnce(
        'modules/core/classes/helpers/GalleryMimeTypeHelper_advanced.class');
    return GalleryMimeTypeHelper_advanced::addMimeType($extension, $mimeType, $viewable);
    }

    /**
     * Fetch the web page at the given url.  Follow redirects to get the data and upon completion
     * return the http response, headers and the actual URL that we used to get the data.
     *
     * @param string $url
     * @param string $outputFile
     * @param array $extraHeaders (optional) extra headers to pass to the server
     * @param array $postDataArray the key/value post data
     * @return array(boolean success, http response, headers, url)
     *  the url is the final url retrieved after redirects
     */
    function fetchWebFile($url, $outputFile, $extraHeaders=array(), $postDataArray=array()) {
    MyOOS_CoreApi::requireOnce('modules/core/classes/helpers/WebHelper_simple.class');
    return WebHelper_simple::fetchWebFile($url, $outputFile, $extraHeaders, $postDataArray);
    }

    /**
     * Fetch the web page at the given url.  Follow redirects to get the data and upon completion
     * return the body, http response, headers and the actual URL that we used to get the data.
     *
     * @param string $url
     * @param array $extraHeaders (optional) extra headers to pass to the server
     * @return array(boolean success, string body, http response, headers, url)
     *    the url is the final url retrieved after redirects
     */
    function fetchWebPage($url, $extraHeaders=array()) {
    MyOOS_CoreApi::requireOnce('modules/core/classes/helpers/WebHelper_simple.class');
    return WebHelper_simple::fetchWebPage($url, $extraHeaders);
    }

    /**
     * Post form data to a remote url and return the http response, headers and body of the reply
     *
     * @param string $url
     * @param array $postDataArray the key/value post data
     * @param array $extraHeaders (optional) extra headers to pass to the server
     * @return array(body, http response, headers)
     */
    function postToWebPage($url, $postDataArray, $extraHeaders=array()) {
    MyOOS_CoreApi::requireOnce('modules/core/classes/helpers/WebHelper_simple.class');
    return WebHelper_simple::postToWebPage($url, $postDataArray, $extraHeaders);
    }

    /**
     * Make an HTTP request to a remote URL and return the HTTP response status, headers and body.
     * @param string $url
     * @param string $requestMethod (optional) the HTTP request method, defaults to 'GET'
     * @param array $requestHeaders (optional) extra headers to pass to the server
     * @param string $requestBody (optional) the request body to pass to the server
     * @return array($responseStatus, $responseHeaders, $responseBody)
     */
    function requestWebPage($url, $requestMethod='GET', $requestHeaders=array(), $requestBody='') {
    MyOOS_CoreApi::requireOnce('modules/core/classes/helpers/WebHelper_simple.class');
    return WebHelper_simple::requestWebPage(
        $url, $requestMethod, $requestHeaders, $requestBody);
    }

    /**
     * Convert the string from the source encoding to UTF8
     *
     * @param string $inputString
     * @param string $sourceEncoding source encoding (eg. 'ISO-8859-1'), defaults to system charset
     * @return string the result
     */
    function convertToUtf8($inputString, $sourceEncoding=null) {
    MyOOS_CoreApi::requireOnce(
        'modules/core/classes/helpers/GalleryCharsetHelper_simple.class');
    return GalleryCharsetHelper_simple::convertToUtf8($inputString, $sourceEncoding);
    }

    /**
     * Convert the string from the internal encoding (UTF-8) to target encoding.
     *
     * @param string $inputString
     * @param string $targetEncoding target encoding (eg. 'ISO-8859-1'), defaults to system charset
     * @return string the result
     */
    function convertFromUtf8($inputString, $targetEncoding=null) {
    MyOOS_CoreApi::requireOnce(
        'modules/core/classes/helpers/GalleryCharsetHelper_simple.class');
    return GalleryCharsetHelper_simple::convertFromUtf8($inputString, $targetEncoding);
    }

    /**
     * mb_substr for UTF-8, with PHP fallback. Truncates incomplete HTML entity at end of result.
     * @param string $string the input string containing raw UTF-8
     * @param int $start the start position
     * @param int $length the length of the substring, not optional
     * @return string a multibyte safe substring of input value
     */
    function utf8Substring($string, $start, $length) {
    MyOOS_CoreApi::requireOnce(
        'modules/core/classes/helpers/GalleryCharsetHelper_simple.class');
    return GalleryCharsetHelper_simple::utf8Substring($string, $start, $length);
    }

    /**
     * mb_strcut for UTF-8, with PHP fallback. Truncates incomplete HTML entity at end of result.
     * @param string $string the input string containing raw UTF-8
     * @param int $start the byte-offset of the start position
     * @param int $length the length in bytes (not in characters), not optional
     * @return string a multibyte safe substring of input value
     */
    function utf8Strcut($string, $start, $length) {
    MyOOS_CoreApi::requireOnce(
        'modules/core/classes/helpers/GalleryCharsetHelper_simple.class');
    return GalleryCharsetHelper_simple::utf8Strcut($string, $start, $length);
    }

    /**
     * Returns an array of directories that can contain plugins.
     *
     * OBSOLETE.  Remove on next major API bump.
     *
     * This function should only be used in special circumstances, for example when a list of all
     * plugins needs to be made.  Currently it returns gallery2/ and gallery2/plugins/.
     */
     function getPluginBaseDirs() {
     return array('base' => dirname(dirname(dirname(dirname(__FILE__)))) . '/');
     }

    /**
     * Returns the base directory of the specified plugin.
     *
     * OBSOLETE.  Remove on next major API bump.
     *
     * Modules should never assume the filesystem location of any module, not even the core module.
     * Use this function to get the base directory of a module. Possible base directories are
     * usually gallery2/ and gallery2/plugins.
     * The complete list can be read with MyOOS_CoreApi::getPluginBaseDirs().
     *
     * @param string $pluginType
     * @param string $pluginId
     * @param bool $clearCache (optional) force index to be reread from the filesystem
     * @return string plugin base directory
     */
    function getPluginBaseDir($pluginType, $pluginId, $clearCache=false) {
    return dirname(dirname(dirname(dirname(__FILE__)))) . '/';
    }

    /**
     * Require a file, but only once. All specified paths must be relative to the Shop
     * directory. Think of it as a virtual PHP include_path.
     *
     * Surprisingly, tracking what's been already loaded in a static variable is actually 10x+
     * faster than just calling require_once directly, even when using this extra API method
     * to wrap it.
     *
     * @param string $file
     */
    function requireOnce($file)
    {
        static $loaded;
        if (!isset($loaded[$file])) {
            $loaded[$file] = true;
            if (strpos($file, '..') !== false) {
                return;
            }
            // debug echo BP . DS . $file .'<br>';
            require BP . DS . $file;
        }
    }


    /**
     * Redirect to another page or site
     *
     * @param string $sUrl
     * @return string
     */
    function redirect($sUrl)
    {
        if ( ( strpos($sUrl, "\n") !== false ) || ( strpos($sUrl, "\r") !== false ) ) {
            $aFilename = oos_get_filename();
            $aModules = oos_get_modules();
	        $sUrl = oos_href_link($aModules['main'], $aFilename['main'], null, 'NONSSL', false);
        }

        if ( strpos($sUrl, '&amp;') !== false ) {
            $sUrl = str_replace('&amp;', '&', $sUrl);
        }

        header('Location: ' . $sUrl);
        oos_exit();
    }




    /**
     * Return an error status.
     *
     * Starting in MyOOS_CoreApi 7.4 we ignore the filename and line number.  You still need to
     * provide them if you want to provide an error message.  Next major API bump we'll remove the
     * fileName and lineNumber arguments.
     *
     * @param int $errorCode
     * @param string $fileName deprecated
     * @param string $lineNumber deprecated
     * @param string $errorMessage
     * @return GalleryStatus an error status
     */
    function error($errorCode, $fileName='ignored', $lineNumber='ignored', $errorMessage=null)
    {
        MyOOS_CoreApi::requireOnce('modules/core/classes/GalleryStatus.class');
        $status = new GalleryStatus(GALLERY_ERROR | $errorCode, $errorMessage);
        $status->setStackTrace(debug_backtrace());
        return $status;
    }


}
