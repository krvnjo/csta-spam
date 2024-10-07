<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property int $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PropertyChild> $property_children
 * @property-read int|null $property_children_count
 * @method static \Illuminate\Database\Eloquent\Builder|Acquisition newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Acquisition newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Acquisition onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Acquisition query()
 * @method static \Illuminate\Database\Eloquent\Builder|Acquisition whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Acquisition whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Acquisition whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Acquisition whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Acquisition whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Acquisition whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Acquisition withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Acquisition withoutTrashed()
 */
	class Acquisition extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string|null $log_name
 * @property string $description
 * @property string|null $subject_type
 * @property string|null $event
 * @property int|null $subject_id
 * @property string|null $causer_type
 * @property int|null $causer_id
 * @property \Illuminate\Support\Collection|null $properties
 * @property string|null $batch_uuid
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent|null $causer
 * @property-read \Illuminate\Support\Collection $changes
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent|null $subject
 * @method static \Illuminate\Database\Eloquent\Builder|AuditHistory causedBy(\Illuminate\Database\Eloquent\Model $causer)
 * @method static \Illuminate\Database\Eloquent\Builder|AuditHistory forBatch(string $batchUuid)
 * @method static \Illuminate\Database\Eloquent\Builder|AuditHistory forEvent(string $event)
 * @method static \Illuminate\Database\Eloquent\Builder|AuditHistory forSubject(\Illuminate\Database\Eloquent\Model $subject)
 * @method static \Illuminate\Database\Eloquent\Builder|AuditHistory hasBatch()
 * @method static \Illuminate\Database\Eloquent\Builder|AuditHistory inLog(...$logNames)
 * @method static \Illuminate\Database\Eloquent\Builder|AuditHistory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AuditHistory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AuditHistory onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|AuditHistory query()
 * @method static \Illuminate\Database\Eloquent\Builder|AuditHistory whereBatchUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AuditHistory whereCauserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AuditHistory whereCauserType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AuditHistory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AuditHistory whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AuditHistory whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AuditHistory whereEvent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AuditHistory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AuditHistory whereLogName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AuditHistory whereProperties($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AuditHistory whereSubjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AuditHistory whereSubjectType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AuditHistory whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AuditHistory withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|AuditHistory withoutTrashed()
 */
	class AuditHistory extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property int $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\PropertyParent|null $property
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PropertyParent> $property_parents
 * @property-read int|null $property_parents_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Subcategory> $subcategories
 * @property-read int|null $subcategories_count
 * @method static \Illuminate\Database\Eloquent\Builder|Brand newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Brand newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Brand onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Brand query()
 * @method static \Illuminate\Database\Eloquent\Builder|Brand whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Brand whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Brand whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Brand whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Brand whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Brand whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Brand withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Brand withoutTrashed()
 */
	class Brand extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $brand_id
 * @property int $subcateg_id
 * @property-read \App\Models\Brand $brand
 * @property-read \App\Models\Subcategory $subcategory
 * @method static \Illuminate\Database\Eloquent\Builder|BrandSubcategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BrandSubcategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BrandSubcategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|BrandSubcategory whereBrandId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BrandSubcategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BrandSubcategory whereSubcategId($value)
 */
	class BrandSubcategory extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property int $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PropertyParent> $property
 * @property-read int|null $property_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PropertyParent> $property_parents
 * @property-read int|null $property_parents_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Subcategory> $subcategories
 * @property-read int|null $subcategories_count
 * @method static \Illuminate\Database\Eloquent\Builder|Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Category query()
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Category withoutTrashed()
 */
	class Category extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string $class
 * @property int $is_color
 * @property int $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|Color newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Color newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Color query()
 * @method static \Illuminate\Database\Eloquent\Builder|Color whereClass($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Color whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Color whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Color whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Color whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Color whereIsColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Color whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Color whereUpdatedAt($value)
 */
	class Color extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\PropertyParent|null $property
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PropertyChild> $propertyChildren
 * @property-read int|null $property_children_count
 * @method static \Illuminate\Database\Eloquent\Builder|Condition newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Condition newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Condition onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Condition query()
 * @method static \Illuminate\Database\Eloquent\Builder|Condition whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Condition whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Condition whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Condition whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Condition whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Condition whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Condition whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Condition withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Condition withoutTrashed()
 */
	class Condition extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string $dept_code
 * @property int $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Designation> $designations
 * @property-read int|null $designations_count
 * @property-read \App\Models\PropertyParent|null $property
 * @property-read \App\Models\PropertyChild|null $propertyChildren
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|Department newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Department newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Department onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Department query()
 * @method static \Illuminate\Database\Eloquent\Builder|Department whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Department whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Department whereDeptCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Department whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Department whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Department whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Department whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Department withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Department withoutTrashed()
 */
	class Department extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property int $dept_id
 * @property int $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Department $department
 * @property-read \App\Models\PropertyParent|null $property
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PropertyChild> $propertyChildren
 * @property-read int|null $property_children_count
 * @method static \Illuminate\Database\Eloquent\Builder|Designation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Designation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Designation onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Designation query()
 * @method static \Illuminate\Database\Eloquent\Builder|Designation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Designation whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Designation whereDeptId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Designation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Designation whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Designation whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Designation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Designation withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Designation withoutTrashed()
 */
	class Designation extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string $guard_name
 * @property int $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Role> $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|Permission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission permission($permissions, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission query()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission role($roles, $guard = null, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereGuardName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission withoutRole($roles, $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission withoutTrashed()
 */
	class Permission extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int $color_id
 * @property int $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|Priority newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Priority newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Priority onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Priority query()
 * @method static \Illuminate\Database\Eloquent\Builder|Priority whereColorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Priority whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Priority whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Priority whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Priority whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Priority whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Priority whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Priority whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Priority withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Priority withoutTrashed()
 */
	class Priority extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $prop_id
 * @property string $prop_code
 * @property string|null $serial_num
 * @property int $type_id
 * @property string|null $acq_date
 * @property string|null $warranty_date
 * @property string $stock_date
 * @property string|null $inventory_date
 * @property int $dept_id
 * @property int $desig_id
 * @property int $condi_id
 * @property int $status_id
 * @property string|null $remarks
 * @property int $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Acquisition $acquisition
 * @property-read \App\Models\Condition $condition
 * @property-read \App\Models\Department $department
 * @property-read \App\Models\Designation $designation
 * @property-read \App\Models\PropertyParent $property
 * @property-read \App\Models\Status $status
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyChild newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyChild newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyChild onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyChild query()
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyChild whereAcqDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyChild whereCondiId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyChild whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyChild whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyChild whereDeptId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyChild whereDesigId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyChild whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyChild whereInventoryDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyChild whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyChild wherePropCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyChild wherePropId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyChild whereRemarks($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyChild whereSerialNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyChild whereStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyChild whereStockDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyChild whereTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyChild whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyChild whereWarrantyDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyChild withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyChild withoutTrashed()
 */
	class PropertyChild extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property int $brand_id
 * @property int|null $categ_id
 * @property int $subcateg_id
 * @property string|null $description
 * @property string|null $image
 * @property int $quantity
 * @property int $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Brand $brand
 * @property-read \App\Models\Category|null $category
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PropertyChild> $propertyChildren
 * @property-read int|null $property_children_count
 * @property-read \App\Models\Subcategory $subcategory
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyParent newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyParent newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyParent onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyParent query()
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyParent whereBrandId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyParent whereCategId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyParent whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyParent whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyParent whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyParent whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyParent whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyParent whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyParent whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyParent whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyParent whereSubcategId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyParent whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyParent withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyParent withoutTrashed()
 */
	class PropertyParent extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string $guard_name
 * @property string $description
 * @property int $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|Role newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Role permission($permissions, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder|Role query()
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereGuardName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Role withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|Role withoutTrashed()
 */
	class Role extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int $color_id
 * @property int $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Color|null $color
 * @property-read \App\Models\PropertyParent|null $property
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PropertyChild> $propertyChildren
 * @property-read int|null $property_children_count
 * @method static \Illuminate\Database\Eloquent\Builder|Status newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Status newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Status onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Status query()
 * @method static \Illuminate\Database\Eloquent\Builder|Status whereColorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Status whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Status whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Status whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Status whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Status whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Status whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Status whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Status withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Status withoutTrashed()
 */
	class Status extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property int $categ_id
 * @property int $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Category $category
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PropertyParent> $properties
 * @property-read int|null $properties_count
 * @method static \Illuminate\Database\Eloquent\Builder|Subcategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Subcategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Subcategory onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Subcategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|Subcategory whereCategId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subcategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subcategory whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subcategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subcategory whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subcategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subcategory whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subcategory withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Subcategory withoutTrashed()
 */
	class Subcategory extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $user_name
 * @property string $pass_hash
 * @property string $lname
 * @property string $fname
 * @property string|null $mname
 * @property int $dept_id
 * @property string $email
 * @property string|null $phone_num
 * @property string $user_image
 * @property string|null $last_login
 * @property int $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Department|null $department
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Role> $roles
 * @property-read int|null $roles_count
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|User permission($permissions, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User role($roles, $guard = null, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDeptId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereFname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLastLogin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereMname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassHash($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePhoneNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUserImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUserName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|User withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|User withoutRole($roles, $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder|User withoutTrashed()
 */
	class User extends \Eloquent {}
}

