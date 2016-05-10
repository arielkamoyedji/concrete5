<?php
namespace Concrete\Core\File\Search\Result;

use Concrete\Core\Application\UserInterface\ContextMenu\BulkMenu;
use Concrete\Core\Application\UserInterface\ContextMenu\Item\LinkItem;
use Concrete\Core\Application\UserInterface\ContextMenu\Menu;
use Concrete\Core\Search\Result\Result as SearchResult;

class Result extends SearchResult
{

    protected $folder;

    /**
     * @return mixed
     */
    public function getFolder()
    {
        return $this->folder;
    }

    /**
     * @param mixed $folder
     */
    public function setFolder($folder)
    {
        $this->folder = $folder;
    }

    public function getJSONObject()
    {
        $r = parent::getJSONObject();
        $r->folder = $this->folder;
        return $r;
    }

    public function getSearchResultBulkMenus()
    {
        $group = new BulkMenu();
        $group->setPropertyName('treeNodeTypeHandle');
        $group->setPropertyValue('file');
        $menu = new Menu();
        $menu->addItem(new LinkItem('#', t('Download'), [
            'data-bulk-action' => 'download'
        ]));
        $menu->addItem(new LinkItem('#', t('Properties'), [
            'data-bulk-action-type' => 'dialog',
            'data-bulk-action-title' => t('Edit Properties'),
            'data-bulk-action-url' => \URL::to('/ccm/system/dialogs/file/bulk/properties'),
            'data-bulk-action-dialog-width' => '630',
            'data-bulk-action-dialog-height' => '450',
        ]));
        $menu->addItem(new LinkItem('#', t('Rescan'), [
            'data-bulk-action-type' => 'ajax',
            'data-bulk-action-url' => \URL::to('/ccm/system/file/rescan')
        ]));

        $menu->addItem(new LinkItem('#', t('Storage Location'), [
            'data-bulk-action-type' => 'dialog',
            'data-bulk-action-title' => t('Storage Location'),
            'data-bulk-action-url' => \URL::to('/ccm/system/dialogs/file/bulk/storage'),
            'data-bulk-action-dialog-width' => '500',
            'data-bulk-action-dialog-height' => '400',
        ]));
        $menu->addItem(new LinkItem('#', t('Delete'), [
            'data-bulk-action-type' => 'dialog',
            'data-bulk-action-title' => t('Delete'),
            'data-bulk-action-url' => \URL::to('/ccm/system/dialogs/file/bulk/delete'),
            'data-bulk-action-dialog-width' => '500',
            'data-bulk-action-dialog-height' => '400',
        ]));

        $group->setMenu($menu);
        return $group;
    }

    public function getItemDetails($item)
    {
        $node = new Item($this, $this->listColumns, $item);

        return $node;
    }

    public function getColumnDetails($column)
    {
        $node = new Column($this, $column);

        return $node;
    }
}
