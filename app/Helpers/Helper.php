<?php

namespace App\Helpers;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class Helper
{


    public static function activeClass($routeName, $routes = [])
    {
        return in_array($routeName, $routes) ? 'active' : '';
    }


    public static function menuOpenClass($routeName, $routes = [])
    {
        return in_array($routeName, $routes) ? 'menu-open' : '';
    }

    /**
     * Generates html badge for \App\Models\Client Status
     */
    public static function activeClientStatuslabel($activeStatus)
    {
        if ($activeStatus == 1) {
            return '<span class="badge badge-success">' . Config::get('constant.ACTIVE_CLIENT_STATUSES')[$activeStatus] . '</span>';
        } else if ($activeStatus == 2) {
            return '<span class="badge badge-primary">' . Config::get('constant.ACTIVE_CLIENT_STATUSES')[$activeStatus] . '</span>';
        } else if ($activeStatus == 3) {
            return '<span class="badge badge-danger">' . Config::get('constant.ACTIVE_CLIENT_STATUSES')[$activeStatus] . '</span>';
        } else {
            return '<span class="badge badge-warning">' . Config::get('constant.ACTIVE_CLIENT_STATUSES')[$activeStatus] . '</span>';
        }
    }

    /**
     * Generates html badge Active/Inactive Status
     */
    public static function activeInactiveStatus($status)
    {
        if ($status == 1) {
            return '<span class="badge badge-success">' . Config::get('constant.ACTIVE_STATUSES')[$status] . '</span>';
        } else if ($status == 0) {
            return '<span class="badge badge-danger">' . Config::get('constant.ACTIVE_STATUSES')[$status] . '</span>';
        } else {
            return "No";
        }
    }

    // This method is for get the name of a constant

    public static function getConstantName($constantName, $value)
    {
        return Config::get('constant.' . $constantName)[$value];
    }

    /*
     * this function will Upload any file to S3 or local disk
     * pass file or base64sting
     * pass destination folderPath with slash added in last
     * if fileName not provided , ans automatic file name will be generated with segmented folder with year & month
     * @return string Image Name With Segmented Folder
     */

    public static function uploadFile($file = null, $base64string = null, $destinationPath, $fileName = null, $disk = null, $extension = null)
    {
        if (!$disk) {
            $disk = env('DISK_TYPE');
        }
        if (!$fileName) {
            if ($file) {
                $fileName = Carbon::now()->format('Y') . '/' . Carbon::now()->format('m') . '/' . uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
            } else {
                if ($extension) {
                    $fileName = Carbon::now()->format('Y') . '/' . Carbon::now()->format('m') . '/' . uniqid() . '_' . time() . $extension;
                } else {
                    $fileName = Carbon::now()->format('Y') . '/' . Carbon::now()->format('m') . '/' . uniqid() . '_' . time() . '.jpg';
                }
            }
        }

        if ($file) {
            $imagePath = Storage::disk($disk)->putFileAs($destinationPath, $file, $fileName, 'public');

            return $imagePath;
        } elseif ($base64string) {
            $imagePath = Storage::disk($disk)->put($destinationPath . '/' . $fileName, $base64string, 'public');

            return $destinationPath . '/' . $fileName;
        } else {
            return null;
        }
    }

    public static function storagePath($filePath)
    {
        return env('CDN_URL') . '/' . $filePath;
    }

    /**
     * This method is for generating formated number.
     */

    public static function generateNumber($value, $string)
    {
        return $string . "-" . str_pad($value, 6, '0', STR_PAD_LEFT);
    }

    /**
     * Generate label for \App\Models\Purchase Status
     */

    public static function purchaseStatusLabel($status)
    {
        if ($status == 0) {
            return '<span class="badge badge-warning">' . Config::get('constant.PURCHASE_STATUSES')[$status] . '</span>';
        } else if ($status == 1) {
            return '<span class="badge badge-info">' . Config::get('constant.PURCHASE_STATUSES')[$status] . '</span>';
        } else if ($status == 2) {
            return '<span class="badge badge-primary">' . Config::get('constant.PURCHASE_STATUSES')[$status] . '</span>';
        } else if ($status == 3) {
            return '<span class="badge badge-warning">' . Config::get('constant.PURCHASE_STATUSES')[$status] . '</span>';
        } else if ($status == 4) {
            return '<span class="badge badge-success">' . Config::get('constant.PURCHASE_STATUSES')[$status] . '</span>';
        } else if ($status == 5) {
            return '<span class="badge badge-primary">' . Config::get('constant.PURCHASE_STATUSES')[$status] . '</span>';
        } else if ($status == 6) {
            return '<span class="badge badge-success">' . Config::get('constant.PURCHASE_STATUSES')[$status] . '</span>';
        } else {
            return '<span class="badge badge-danger">' . Config::get('constant.PURCHASE_STATUSES')[$status] . '</span>';
        }
    }

    public static function productTransferStatusLabel($status)
    {
        if ($status == 0) {
            return '<span class="badge badge-warning">' . Config::get('constant.PRODUCT_TRANSFER_STATUSES')[$status] . '</span>';
        } else if ($status == 1) {
            return '<span class="badge badge-info">' . Config::get('constant.PRODUCT_TRANSFER_STATUSES')[$status] . '</span>';
        } else if ($status == 2) {
            return '<span class="badge badge-primary">' . Config::get('constant.PRODUCT_TRANSFER_STATUSES')[$status] . '</span>';
        } else if ($status == 3) {
            return '<span class="badge badge-warning">' . Config::get('constant.PRODUCT_TRANSFER_STATUSES')[$status] . '</span>';
        } else if ($status == 4) {
            return '<span class="badge badge-success">' . Config::get('constant.PRODUCT_TRANSFER_STATUSES')[$status] . '</span>';
        } else if ($status == 5) {
            return '<span class="badge badge-primary">' . Config::get('constant.PRODUCT_TRANSFER_STATUSES')[$status] . '</span>';
        } else if ($status == 6) {
            return '<span class="badge badge-success">' . Config::get('constant.PRODUCT_TRANSFER_STATUSES')[$status] . '</span>';
        } else {
            return '<span class="badge badge-danger">' . Config::get('constant.PRODUCT_TRANSFER_STATUSES')[$status] . '</span>';
        }
    }

    public static function bankAccountStatusLabel($status)
    {
        if ($status == 0) {
            return '<span class="badge badge-warning">' . Config::get('constant.BANK_ACCOUNT_STATUSES')[$status] . '</span>';
        } else if ($status == 1) {
            return '<span class="badge badge-info">' . Config::get('constant.BANK_ACCOUNT_STATUSES')[$status] . '</span>';
        } else if ($status == 2) {
            return '<span class="badge badge-success">' . Config::get('constant.BANK_ACCOUNT_STATUSES')[$status] . '</span>';
        } else if ($status == 3) {
            return '<span class="badge badge-primary">' . Config::get('constant.BANK_ACCOUNT_STATUSES')[$status] . '</span>';
        } else {
            return '<span class="badge badge-danger">' . Config::get('constant.BANK_ACCOUNT_STATUSES')[$status] . '</span>';
        }
    }

    public static function branchStatusLabel($status)
    {
        if ($status == 0) {
            return '<span class="badge badge-warning">' . Config::get('constant.BRANCH_STATUSES')[$status] . '</span>';
        } else if ($status == 1) {
            return '<span class="badge badge-success">' . Config::get('constant.BRANCH_STATUSES')[$status] . '</span>';
        } else if ($status == 2) {
            return '<span class="badge badge-info">' . Config::get('constant.BRANCH_STATUSES')[$status] . '</span>';
        } else {
            return '<span class="badge badge-danger">' . Config::get('constant.BANK_ACCOUNT_STATUSES')[$status] . '</span>';
        }
    }

    /**
     * Generate label for \App\Models\Purchase Status
     */

    public static function productionStatusLabel($status)
    {
        if ($status == 0) {
            return '<span class="badge badge-warning">' . Config::get('constant.PRODUCTION_STATUSES')[$status] . '</span>';
        } else if ($status == 1) {
            return '<span class="badge badge-info">' . Config::get('constant.PRODUCTION_STATUSES')[$status] . '</span>';
        } else if ($status == 2) {
            return '<span class="badge badge-primary">' . Config::get('constant.PRODUCTION_STATUSES')[$status] . '</span>';
        } else if ($status == 3) {
            return '<span class="badge badge-success">' . Config::get('constant.PRODUCTION_STATUSES')[$status] . '</span>';
        } else {
            return '<span class="badge badge-danger">' . Config::get('constant.PRODUCTION_STATUSES')[$status] . '</span>';
        }
    }

    /**
     * Format a number as money.
     */

    public static function money($value)
    {
        return number_format($value, 2, ".", ",");
    }


    //check edited it is Authorized
    public static function idIsAuthorized($modelInstance)
    {
        if ($modelInstance->client_id === Auth::user()->client_id) {
            return true;
        } else {
            Session::flash('error', 'You Are Unauthorized to access.');
            return false;
        }
    }
}
