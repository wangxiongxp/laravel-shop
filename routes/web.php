<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['prefix' => '/'], function () {

    Route::get('', 'Web\Home\IndexController@index');

    Route::get('/intro/{id}', 'Web\Home\IndexController@introduction');

    Route::get('/category', 'Web\Home\IndexController@category');

    Route::get('/search', 'Web\Home\IndexController@search');

    Route::get('/shopCart', 'Web\Home\IndexController@cart');

    Route::get('/sendSMSCode/{num}', 'CommonController@sendSMSCode');

});

Route::group(['middleware' => 'auth:web'], function () {

    Route::get('/home', 'Web\HomeController@index');

    //个人资料
    Route::get('/profile', 'Web\Personal\ProfileController@index');
    Route::get('/information', 'Web\Personal\ProfileController@information');
    Route::post('/information/update', 'Web\Personal\ProfileController@updateInformation');
    Route::get('/safety', 'Web\Personal\ProfileController@safety');
    Route::get('/password', 'Web\Personal\ProfileController@password');
    Route::get('/bindPhone', 'Web\Personal\ProfileController@bindPhone');
    Route::get('/email', 'Web\Personal\ProfileController@bindPhone');
    Route::get('/idCard', 'Web\Personal\ProfileController@idCard');
    Route::get('/question', 'Web\Personal\ProfileController@question');
    Route::get('/setPay', 'Web\Personal\ProfileController@setPay');

    //地址
    Route::get('/address', 'Web\Personal\AddressController@index');
    Route::post('/address/setDefault', 'Web\Personal\AddressController@setDefault');

    //订单管理
    Route::get('/order', 'Web\Personal\OrderController@index');
    Route::get('/order/view', 'Web\Personal\OrderController@view');
    Route::get('/order/logistics', 'Web\Personal\OrderController@logistics');

    //退款售后
    Route::get('/change', 'Web\Personal\ChangeController@index');
    Route::get('/record', 'Web\Personal\ChangeController@record');

    //优惠券
    Route::get('/coupon', 'Web\Personal\CouponController@index');

    //红包
    Route::get('/bonus', 'Web\Personal\BonusController@index');

    //账单明细
    Route::get('/bill', 'Web\Personal\BillController@index');
    Route::get('/billList', 'Web\Personal\BillController@billList');

    //收藏
    Route::get('/collection', 'Web\Personal\CollectionController@index');
    Route::get('/collection/queryCollection', 'Web\Personal\CollectionController@queryCollection');

    //足记
    Route::get('/foot', 'Web\Personal\FootController@index');
    Route::get('/foot/queryFoot', 'Web\Personal\FootController@queryFoot');

    //评价
    Route::get('/comment', 'Web\Personal\CommentController@index');

    //消息
    Route::get('/news', 'Web\Personal\NewsController@index');

    //博客
    Route::get('/blog', 'Web\Personal\BlogController@index');

});

Route::group(['prefix' => 'admin'], function () {
    Route::get('login', 'Admin\Auth\LoginController@showLoginForm');
    Route::post('login', 'Admin\Auth\LoginController@login');
    Route::get('register', 'Admin\Auth\RegisterController@showRegistrationForm');
    Route::post('register', 'Admin\Auth\RegisterController@register');
});

Route::group(['middleware' => 'auth:admin', 'prefix' => 'admin'], function() {

    Route::get('/', 'Admin\HomeController@index');

    Route::get('/logout', 'Admin\Auth\LoginController@logout');

    Route::post('/uploadImage', 'UploadController@uploadImage');

    Route::get('/profile', 'Admin\ProfileController@index');
    Route::get('/switchRole', 'Admin\AccountController@switchRole');

    //会员管理
    Route::get('/userList', 'Admin\Member\UserController@index');
    Route::post('/userList/queryUser', 'Admin\Member\UserController@queryUser');
    Route::get('/userList/userDetail', 'Admin\Member\UserController@userDetail');

    //会员成长值管理
    Route::get('/growth', 'Admin\Member\GrowthController@index');
    Route::post('/growth/query', 'Admin\Member\GrowthController@queryGrowth');
    Route::post('/growth/save', 'Admin\Member\GrowthController@saveGrowth');
    Route::post('/growth/update', 'Admin\Member\GrowthController@updateGrowth');
    Route::get('/growth/delete/{id}', 'Admin\Member\GrowthController@deleteGrowth');

    //会员积分规则管理
    Route::get('/growthEvent', 'Admin\Member\GrowthEventController@index');
    Route::post('/growthEvent/query', 'Admin\Member\GrowthEventController@queryGrowthEvent');
    Route::post('/growthEvent/save', 'Admin\Member\GrowthEventController@saveGrowthEvent');
    Route::post('/growthEvent/update', 'Admin\Member\GrowthEventController@updateGrowthEvent');
    Route::get('/growthEvent/delete/{id}', 'Admin\Member\GrowthEventController@deleteGrowthEvent');

    //会员成长值明细
    Route::get('/userGrowth', 'Admin\Member\UserController@growth');
    //会员购物车
    Route::get('/userCart', 'Admin\Member\UserController@shopCart');
    //会员收藏
    Route::get('/userCollection', 'Admin\Member\UserController@collection');

    //管理员管理
    Route::get('/account', 'Admin\AccountController@index');
    Route::post('/account/query', 'Admin\AccountController@queryAccount');
    Route::post('/account/save', 'Admin\AccountController@saveAccount');
    Route::post('/account/update', 'Admin\AccountController@updateAccount');
    Route::get('/account/delete/{id}', 'Admin\AccountController@deleteAccount');
    Route::get('/account/showResetPassword/{id}', 'Admin\AccountController@showResetPassword');
    Route::post('/account/resetPassword', 'Admin\AccountController@resetPassword');

    //登陆日志
    Route::get('/loginLog', 'Admin\Log\LoginLogController@index');
    Route::post('/loginLog/query', 'Admin\Log\LoginLogController@queryLoginLog');
    Route::get('/loginLog/delete/{id}', 'Admin\Log\LoginLogController@deleteLoginLog');

    //角色管理
    Route::get('/role', 'Admin\RoleController@index');
    Route::post('/role/query', 'Admin\RoleController@queryRole');
    Route::get('/role/add', 'Admin\RoleController@addRole');
    Route::post('/role/save', 'Admin\RoleController@saveRole');
    Route::get('/role/edit/{id}', 'Admin\RoleController@editRole');
    Route::post('/role/update', 'Admin\RoleController@updateRole');
    Route::get('/role/delete/{id}', 'Admin\RoleController@deleteRole');
    Route::get('/role/getRoleTree', 'Admin\RoleController@getRoleTree');
    Route::get('/role/selectMenus/{id}', 'Admin\RoleController@selectMenus');
    Route::post('/role/saveMenus', 'Admin\RoleController@saveMenus');

    //角色成员管理
    Route::get('/roleMember', 'Admin\RoleMemberController@index');
    Route::post('/roleMember/query', 'Admin\RoleMemberController@queryRoleMember');
    Route::get('/roleMember/add', 'Admin\RoleMemberController@addRoleMember');
    Route::post('/roleMember/save', 'Admin\RoleMemberController@saveRoleMember');
    Route::get('/roleMember/delete/{s_role_id}/{account_id}', 'Admin\RoleMemberController@deleteRoleMember');

    //群组管理
    Route::get('/group', 'Admin\GroupController@index');
    Route::get('/group/get/{id}', 'Admin\GroupController@getGroupById');
    Route::get('/group/add', 'Admin\GroupController@addGroup');
    Route::post('/group/save', 'Admin\GroupController@saveGroup');
    Route::get('/group/edit/{id}', 'Admin\GroupController@editGroup');
    Route::post('/group/update', 'Admin\GroupController@updateGroup');
    Route::get('/group/delete/{id}', 'Admin\GroupController@deleteGroup');
    Route::get('/group/getGroupTree', 'Admin\GroupController@getGroupTree');

    //群组成员管理
    Route::get('/groupMember', 'Admin\GroupMemberController@index');
    Route::post('/groupMember/query', 'Admin\GroupMemberController@queryGroupMember');
    Route::get('/groupMember/add', 'Admin\GroupMemberController@addGroupMember');
    Route::post('/groupMember/save', 'Admin\GroupMemberController@saveGroupMember');
    Route::get('/groupMember/delete/{s_group_id}/{account_id}', 'Admin\GroupMemberController@deleteGroupMember');
    Route::get('/groupMember/selectGroup/{account_id}', 'Admin\GroupMemberController@selectGroup');
    Route::post('/groupMember/saveGroupGrant', 'Admin\GroupMemberController@saveGroupGrant');
    Route::get('/groupMember/getSelectedGroupTree/{account_id}', 'Admin\GroupMemberController@getSelectedGroupTree');

    //菜单管理
    Route::get('/menu', 'Admin\MenuController@index');
    Route::get('/menu/add', 'Admin\MenuController@addMenu');
    Route::post('/menu/save', 'Admin\MenuController@saveMenu');
    Route::get('/menu/edit/{id}', 'Admin\MenuController@editMenu');
    Route::post('/menu/update', 'Admin\MenuController@updateMenu');
    Route::get('/menu/delete/{id}', 'Admin\MenuController@deleteMenu');
    Route::get('/menu/getFirstMenu', 'Admin\MenuController@getFirstMenu');
    Route::get('/menu/getMenuTree', 'Admin\MenuController@getMenuTree');

    //内容管理===栏目
    Route::get('/cms/catalog', 'Admin\Cms\CatalogController@index');
    Route::get('/cms/catalog/add', 'Admin\Cms\CatalogController@addCatalog');
    Route::post('/cms/catalog/save', 'Admin\Cms\CatalogController@saveCatalog');
    Route::get('/cms/catalog/edit/{id}', 'Admin\Cms\CatalogController@editCatalog');
    Route::post('/cms/catalog/update', 'Admin\Cms\CatalogController@updateCatalog');
    Route::get('/cms/catalog/delete/{id}', 'Admin\Cms\CatalogController@deleteCatalog');
    Route::get('/cms/catalog/getCatalogByParent/{id}', 'Admin\Cms\CatalogController@getCatalogByParent');

    //内容管理===文章
    Route::get('/cms/article', 'Admin\Cms\ArticleController@index');
    Route::post('/cms/article/query', 'Admin\Cms\ArticleController@queryArticle');
    Route::post('/cms/article/save', 'Admin\Cms\ArticleController@saveArticle');
    Route::post('/cms/article/update', 'Admin\Cms\ArticleController@updateArticle');
    Route::get('/cms/article/delete/{id}', 'Admin\Cms\ArticleController@deleteArticle');
    Route::get('/cms/article/updateIsTopStatus/{id}/{status}', 'Admin\Cms\ArticleController@updateIsTopStatus');
    Route::get('/cms/article/updateCommentStatus/{id}/{status}', 'Admin\Cms\ArticleController@updateCommentStatus');
    Route::get('/cms/article/updateVisibilityStatus/{id}/{status}', 'Admin\Cms\ArticleController@updateVisibilityStatus');

    //内容管理===评论
    Route::get('/cms/comment', 'Admin\Cms\CommentController@index');
    Route::post('/cms/comment/query', 'Admin\Cms\CommentController@queryComment');
    Route::get('/cms/comment/delete/{id}', 'AdminCms\CommentController@deleteComment');
    Route::get('/cms/comment/view/{id}', 'Admin\Cms\CommentController@viewComment');
    Route::get('/cms/comment/edit/{id}', 'Admin\Cms\CommentController@editComment');
    Route::post('/cms/comment/update', 'Admin\Cms\CommentController@updateComment');
    Route::post('/cms/comment/updateStatus', 'Admin\Cms\CommentController@updateStatus');

    //导航管理
    Route::get('/navigation', 'Admin\NavigationController@index');
    Route::post('/navigation/save', 'Admin\NavigationController@saveNavigation');
    Route::post('/navigation/update', 'Admin\NavigationController@updateNavigation');
    Route::get('/navigation/delete/{id}', 'Admin\NavigationController@deleteNavigation');
    Route::get('/navigation/getFirstNav', 'Admin\NavigationController@getFirstNav');

    //产品类别管理
    Route::get('/productCat', 'Admin\Product\ProductCatController@index');
    Route::post('/productCat/save', 'Admin\Product\ProductCatController@saveProductCat');
    Route::post('/productCat/update', 'Admin\Product\ProductCatController@updateProductCat');
    Route::get('/productCat/delete/{id}', 'Admin\Product\ProductCatController@deleteProductCat');
    Route::get('/productCat/getFirstCategory', 'Admin\Product\ProductCatController@getFirstCategory');
    Route::get('/productCat/getCatalogByParent/{id}', 'Admin\Product\ProductCatController@getCatalogByParent');

    //产品类别属性管理
    Route::get('/productCatAttr', 'Admin\Product\ProductCatAttrController@index');
    Route::post('/productCatAttr/save', 'Admin\Product\ProductCatAttrController@saveProductCatAttr');
    Route::post('/productCatAttr/update', 'Admin\Product\ProductCatAttrController@updateProductCatAttr');
    Route::get('/productCatAttr/delete/{id}', 'Admin\Product\ProductCatAttrController@deleteProductCatAttr');
    Route::get('/productCatAttr/getProductCatAttrByCatId', 'Admin\Product\ProductCatAttrController@getProductCatAttrByCatId');

    //产品类别属性值管理
    Route::get('/productCatAttrOption', 'Admin\Product\ProductCatAttrOptionController@index');
    Route::post('/productCatAttrOption/save', 'Admin\Product\ProductCatAttrOptionController@saveProductCatAttrOption');
    Route::post('/productCatAttrOption/update', 'Admin\Product\ProductCatAttrOptionController@updateProductCatAttrOption');
    Route::get('/productCatAttrOption/delete/{id}', 'Admin\Product\ProductCatAttrOptionController@deleteProductCatAttrOption');

    //产品管理
    Route::get('/product', 'Admin\Product\ProductController@index');
    Route::post('/product/query', 'Admin\Product\ProductController@queryProduct');
    Route::post('/product/save', 'Admin\Product\ProductController@saveProduct');
    Route::post('/product/update', 'Admin\Product\ProductController@updateProduct');
    Route::post('/product/updateStatus/{id}/{status}', 'Admin\Product\ProductController@updateStatus');
    Route::get('/product/delete/{id}', 'Admin\Product\ProductController@deleteProduct');

    //品牌管理
    Route::get('/brand', 'Admin\Product\BrandController@index');
    Route::post('/brand/query', 'Admin\Product\BrandController@queryBrand');
    Route::post('/brand/save', 'Admin\Product\BrandController@saveBrand');
    Route::post('/brand/update', 'Admin\Product\BrandController@updateBrand');
    Route::get('/brand/delete/{id}', 'Admin\Product\BrandController@deleteBrand');
    Route::get('/brand/getAllBrand', 'Admin\Product\BrandController@getAllBrand');

    //广告管理
    Route::get('/ad', 'Admin\AdController@index');
    Route::post('/ad/query', 'Admin\AdController@queryAd');
    Route::post('/ad/save', 'Admin\AdController@saveAd');
    Route::post('/ad/update', 'Admin\AdController@updateAd');
    Route::get('/ad/delete/{id}', 'Admin\AdController@deleteAd');
    Route::get('/adItem', 'Admin\AdController@adItem');
    Route::post('/adItem/save', 'Admin\AdController@saveAdItem');
    Route::post('/adItem/update', 'Admin\AdController@updateAdItem');
    Route::get('/adItem/delete/{id}', 'Admin\AdController@deleteAdItem');


    //友情链接
    Route::get('/friendLink', 'Admin\FriendLinkController@index');
    Route::post('/friendLink/query', 'Admin\FriendLinkController@queryFriendLink');
    Route::post('/friendLink/save', 'Admin\FriendLinkController@saveFriendLink');
    Route::post('/friendLink/update', 'Admin\FriendLinkController@updateFriendLink');
    Route::get('/friendLink/delete/{id}', 'Admin\FriendLinkController@deleteFriendLink');

    //优惠券管理
    Route::get('/coupon', 'Admin\CouponController@index');
    Route::post('/coupon/query', 'Admin\CouponController@queryCoupon');
    Route::post('/coupon/save', 'Admin\CouponController@saveCoupon');
    Route::post('/coupon/update', 'Admin\CouponController@updateCoupon');
    Route::get('/coupon/delete/{id}', 'Admin\CouponController@deleteCoupon');
    Route::get('/coupon/updateStatus/{id}/{status}', 'Admin\CouponController@updateStatus');
    //优惠券商品列表
    Route::get('/coupon/listGoods/{id}', 'Admin\CouponController@listCouponGoods');
    Route::post('/coupon/queryGoods/{id}', 'Admin\CouponController@queryCouponGoods');
    Route::get('/coupon/selectGoods', 'Admin\CouponController@selectGoods');
    Route::post('/coupon/querySelectGoods', 'Admin\CouponController@querySelectGoods');
    Route::post('/coupon/saveCouponGoods', 'Admin\CouponController@saveCouponGoods');
    Route::get('/coupon/deleteGoodsById/{id}', 'Admin\CouponController@deleteCouponGoodsById');

    //促销管理
    Route::get('/promotion', 'Admin\PromotionController@index');
    Route::post('/promotion/query', 'Admin\PromotionController@queryPromotion');
    Route::post('/promotion/save', 'Admin\PromotionController@savePromotion');
    Route::post('/promotion/update', 'Admin\PromotionController@updatePromotion');
    Route::get('/promotion/delete/{id}', 'Admin\PromotionController@deletePromotion');
    Route::get('/promotion/updateStatus/{id}/{status}', 'Admin\PromotionController@updateStatus');
    //促销商品列表
    Route::get('/promotion/listGoods/{id}', 'Admin\PromotionController@listPromotionGoods');
    Route::post('/promotion/queryGoods/{id}', 'Admin\PromotionController@queryPromotionGoods');
    Route::get('/promotion/selectGoods', 'Admin\PromotionController@selectGoods');
    Route::post('/promotion/querySelectGoods', 'Admin\PromotionController@querySelectGoods');
    Route::post('/promotion/savePromotionGoods', 'Admin\PromotionController@savePromotionGoods');
    Route::get('/promotion/deleteGoodsById/{id}', 'Admin\PromotionController@deletePromotionGoodsById');

    //促销小工具管理
    Route::get('/award/cards', 'Admin\AwardController@cards');
    Route::get('/award/wheel', 'Admin\AwardController@wheel');
    Route::get('/award/goldenEgg', 'Admin\AwardController@goldenEgg');
    Route::get('/award/zodiac', 'Admin\AwardController@zodiac');
    Route::get('/award/shake', 'Admin\AwardController@shake');
    Route::post('/award/query', 'Admin\AwardController@queryAward');
    Route::post('/award/save', 'Admin\AwardController@saveAward');
    Route::post('/award/update', 'Admin\AwardController@updateAward');
    Route::get('/award/delete/{id}', 'Admin\AwardController@deleteAward');

    //频道管理
    Route::get('/channel', 'Admin\ChannelController@index');
    Route::post('/channel/query', 'Admin\ChannelController@queryChannel');
    Route::post('/channel/save', 'Admin\ChannelController@saveChannel');
    Route::post('/channel/update', 'Admin\ChannelController@updateChannel');
    Route::get('/channel/delete/{id}', 'Admin\ChannelController@deleteChannel');

    //专题管理
    Route::get('/topic', 'Admin\TopicController@index');
    Route::post('/topic/query', 'Admin\TopicController@queryTopic');
    Route::post('/topic/save', 'Admin\TopicController@saveTopic');
    Route::post('/topic/update', 'Admin\TopicController@updateTopic');
    Route::get('/topic/delete/{id}', 'Admin\TopicController@deleteTopic');

    //物流策略
    Route::get('/shipping', 'Admin\ShippingController@index');
    Route::post('/shipping/query', 'Admin\ShippingController@queryShipping');
    Route::post('/shipping/save', 'Admin\ShippingController@saveShipping');
    Route::post('/shipping/update', 'Admin\ShippingController@updateShipping');
    Route::get('/shipping/delete/{id}', 'Admin\ShippingController@deleteShipping');

    //物流公司
    Route::get('/shippingCompany', 'Admin\ShippingCompanyController@index');
    Route::post('/shippingCompany/query', 'Admin\ShippingCompanyController@queryShippingCompany');
    Route::post('/shippingCompany/save', 'Admin\ShippingCompanyController@saveShippingCompany');
    Route::post('/shippingCompany/update', 'Admin\ShippingCompanyController@updateShippingCompany');
    Route::get('/shippingCompany/delete/{id}', 'Admin\ShippingCompanyController@deleteShippingCompany');
    Route::get('/shippingCompany/getShippingCompany', 'Admin\ShippingCompanyController@getShippingCompany');

    //留言管理
    Route::get('/message', 'Admin\MessageController@index');
    Route::post('/message/query', 'Admin\MessageController@queryMessage');
    Route::post('/message/save', 'Admin\MessageController@saveMessage');
    Route::post('/message/update', 'Admin\MessageController@updateMessage');
    Route::get('/message/delete/{id}', 'Admin\MessageController@deleteMessage');

    //页面管理
    Route::get('/page', 'Admin\PageController@index');
    Route::post('/page/query', 'Admin\PageController@queryPage');
    Route::post('/page/save', 'Admin\PageController@savePage');
    Route::post('/page/update', 'Admin\PageController@updatePage');
    Route::get('/page/delete/{id}', 'Admin\PageController@deletePage');

    //限时特价
    Route::get('/special', 'Admin\SpecialController@index');
    Route::post('/special/query', 'Admin\SpecialController@querySpecial');
    Route::post('/special/save', 'Admin\SpecialController@saveSpecial');
    Route::post('/special/update', 'Admin\SpecialController@updateSpecial');
    Route::get('/special/delete/{id}', 'Admin\SpecialController@deleteSpecial');
    Route::get('/special/deleteExpiredGoods/{id}', 'Admin\SpecialController@deleteExpiredGoods');
    //限时特价商品列表
    Route::get('/special/listGoods/{id}', 'Admin\SpecialController@listSpecialGoods');
    Route::post('/special/queryGoods/{id}', 'Admin\SpecialController@querySpecialGoods');
    Route::get('/special/selectGoods', 'Admin\SpecialController@selectGoods');
    Route::post('/special/querySelectGoods', 'Admin\SpecialController@querySelectGoods');
    Route::post('/special/saveSpecialGoods', 'Admin\SpecialController@saveSpecialGoods');
    Route::get('/special/deleteGoodsById/{id}', 'Admin\SpecialController@deleteSpecialGoodsById');

    //订单管理
    Route::get('/order', 'Admin\OrderController@index');
    Route::post('/order/query', 'Admin\OrderController@queryOrder');

    //网站设置
    Route::get('/sysParam/website', 'Admin\SysParamController@website');
    Route::post('/sysParam/save', 'Admin\SysParamController@saveParam');
    Route::post('/sysParam/sendEmail', 'Admin\SysParamController@sendEmail');
    Route::post('/sysParam/sendMessage/{tel}', 'Admin\SysParamController@sendMessage');

});

Auth::routes();
