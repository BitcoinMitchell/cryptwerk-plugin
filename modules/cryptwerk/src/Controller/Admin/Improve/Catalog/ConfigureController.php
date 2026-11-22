<?php

namespace CryptWerk\Controller\Admin\Improve\Catalog;

use Module;
use PrestaShopBundle\Controller\Admin\PrestaShopAdminController;
use PrestaShopBundle\Security\Attribute\AdminSecurity;
use Symfony\Component\HttpFoundation\Response;

class ConfigureController extends PrestaShopAdminController
{
	#[AdminSecurity("is_granted('read', request.get('_legacy_controller'))", message: 'Access denied.')]
	public function configureAction(): Response
	{
		if (!Module::isEnabled('cryptwerk')) {
			return $this->redirectToRoute('admin_module_manage');
		}

		return $this->redirect(\Context::getContext()->link->getModuleLink('cryptwerk', 'feed'));
	}
}
