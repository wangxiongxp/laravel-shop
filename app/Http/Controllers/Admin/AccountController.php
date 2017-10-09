<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\AccountService;
use App\Services\RoleService;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    protected $accountService;

    public function __construct(AccountService $accountService)
    {
        $this->middleware('auth');
        $this->accountService = $accountService;
    }

    public function index(Request $request)
    {
        $act = $request['act'] ? $request['act'] : '' ;
        if($act == 'add'){
            return view('admin/account/addAccount');
        }elseif ($act == 'edit'){
            $data = array();
            $article = $this->accountService->getAccountById($request['id']);
            $data['account'] = $article ;
            return view('admin/account/editAccount',$data);
        }else{
            return view('admin/account/index');
        }
    }

    public function queryAccount(Request $request)
    {
        $queryParam = $this->buildSearchParam($request);
        $queryParam['account_type'] = 1 ;//1为管理员账号
        $result = $this->accountService->queryAccount($queryParam);
        return $this->showPageResult($result);
    }

    public function saveAccount(Request $request)
    {
        $request['account_type'] = 1 ;
        $request['password'] = bcrypt($request['password']) ;
        $this->accountService->insertAccount($request->all());
        return $this->showJsonResult(true, '保存成功', null);
    }

    public function updateAccount(Request $request)
    {
        if(empty($request['password'])){
            unset($request['password']);
        }else{
            $request['password'] = bcrypt($request['password']) ;
        }
        $this->accountService->updateAccount($request->all());
        return $this->showJsonResult(true, '更新成功', null);
    }

    public function deleteAccount($id)
    {
        $this->accountService->deleteAccount($id);
        return $this->showJsonResult(true, '删除成功', null);
    }

    public function showResetPassword($account_id){
        $data = array();
        $data['account_id'] = $account_id ;

        return view('admin/account/password',$data);
    }

    public function resetPassword(Request $request)
    {
        $account_id = $request['account_id'];
        $password = bcrypt($request['password']) ;
        $this->accountService->updateAccountPassword($account_id,$password);
        return $this->showJsonResult(true, '更新成功', null);
    }

    public function switchRole(Request $request)
    {
        $s_role_id = $request['role_id'];

        $roleService = new RoleService();
        $roleInfo = $roleService->getRoleById($s_role_id);
        Session::put("curRole", $roleInfo);

        $roleService = new RoleService();
        $menus = $roleService->GetMenuTreeOfRole(0, $s_role_id);
        Session::put("menus", $menus);

        return $this->showJsonResult(true, '更新成功', null);
    }

    public function exportUser(Request $request)
    {
        $objExcel = new \PHPExcel();
//        $objExcel->getProperties()->setCreator("Maarten Balliauw")
//            ->setLastModifiedBy("Maarten Balliauw")
//            ->setTitle("Office 2007 XLSX Test Document")
//            ->setSubject("Office 2007 XLSX Test Document")
//            ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
//            ->setKeywords("office 2007 openxml php")
//            ->setCategory("Test result file");

        $objExcel->setActiveSheetIndex(0);
        $objActSheet = $objExcel->getActiveSheet();

        $rows = $this->accountService->getExportUser($request);

        $objActSheet->setCellValue("A1", "ID");
        $objActSheet->setCellValue("B1", "用户名");
        $objActSheet->setCellValue("C1", "真实姓名");
        $objActSheet->setCellValue("D1", "邮箱");
        $objActSheet->setCellValue("E1", "电话");

        $rowIndex = 2;
        foreach( $rows as $row ){
            $objActSheet->setCellValue("A$rowIndex", $row['account_id']);
            $objActSheet->setCellValue("B$rowIndex", $row['account_name']);
            $objActSheet->setCellValue("C$rowIndex", $row['account_real_name']);
            $objActSheet->setCellValue("D$rowIndex", $row['account_email']);
            $objActSheet->setCellValue("E$rowIndex", $row['account_tel']);
            $rowIndex++;
        }

//        $objActSheet->setTitle('Simple');
//        $objExcel->setActiveSheetIndex(0);

        $objWriter = \PHPExcel_IOFactory::createWriter($objExcel, 'Excel5');
        $outputFileName = "".date("Y-m-d",time()).".xls";
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$outputFileName.'"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
        header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header ('Pragma: public'); // HTTP/1.0
        $objWriter->save('php://output');
        exit;

    }


}
