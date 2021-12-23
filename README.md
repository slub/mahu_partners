# TYPO3 extension `mahu_partners`

The extension `mahu_partners` offers the domain model for companies / institutes and regulations used in the [Material Hub](https://www.materialhub.de). In addition, it provides listings, search functionality and detail pages for both entities. 

Furthermore, the extension comes with a frontend editor for company / institute records. In this regard, each Company record is associated with the user that created it. A listing of the records created by the currently logged in user is a further feature of this extension.

In addition there is a simple file management per Company record. To this end, the extension offers a listing of files in the directory associated with the Company and allows to upload new files, respectively, delete existing ones.

## Development

All Material Hub extension are shipped with a [grunt](https://gruntjs.com/) configuration \(requires [Node.js](https://nodejs.org/en/)\). This ensures that during development the files from /Resources/Private/Css and /Resources/Private/JavaScript are copied to /Resources/Public as soon as changes occur. For this purpose, the command `grunt` must be executed in the root directory of the respective project via the console. Before committing to git, it is recommended to automatically generate a "production version" with the command `grunt buildProd`, where minified files are stored in the /Resources/Public folder.

## Usage

### Setup

- Add the plugin as a content element and select a view mode in the plugin options. Available modes are described below.
- Include the static TypoScript "Mahu Frontend partners extension".
- Configure the extension via TypoScript.
    - a complete list of options can be found [below](#typoScript-configuration-options)
    - set the `plugin.tx_mahupartners.persistence.storagePid` to the folders containing relevant records


### Plugin modes
Once the plugin is added as a content element, one of the plugin modes can be selected via flexform:

| Mode | Description |
| ---- | ----------- |
| Partner | Search functionality and detail pages for companies / institutes|
| Partnerliste für Nutzer | Lists the companies / institutes created by the current user |
| Partner Editieransicht | Frontend editor for companies / institutes |
| Regulations | Search functionality and detail pages for regulations |
| Neueste Partner | Lists Company records. |
| Dateien | Simple file management per Company (list, add, remove). |


## TypoScript Configuration Options

To configure this extension, the following settings are supported as part of the array `plugin.tx_mahupartners.settings` of the TypoScript setup configuration.

- `showLogos` (defaults to true): Indicates whether logos of companies / institutes should be displayed in certain views.
- `prefix` (defaults to tx_mahupartners_mahupartners): The prefix used for URL generation of "show materials of partner XY" and "show corresponding materials" links.
- `regulationSearchPageID`: Id of the regulation search page
- `partnerSearchPageID`: Id of the company / institute search page
- `dataproviderPageID`: Id of the data provider area page
- `orgaDescriptionPageID`: Id of the organization description page
- `orgaDescriptionPreviewPageID`: Id of the company / institute preview page
- `materialEditorPageID`: Id of the Material Editor page
- `contactPageID`: Id of the contact page
- `uploadPageID`: Id of the page that allows users to upload files.
- `materialSearchPageID`: Id of the materials search page

### Settings for file management

When creating or editing a new company / institute record, a logo file can be uploaded. In addition, users can upload files like material descriptions. Such files are stored in a Company-specific folder. The storage and parent folder of those directories can, amongst other settings, be configured as follows:

- `imageUpload`
    - `path` (defaults to /user_upload/): the parent directory of user folders
    - `storage` (defaults to 1): the storage in which the defined path exists
    - `siteURL`: the root site's URL, e.g. https://www.example.org/
- `dateFormat` (defaults to d.m.Y H:i): configures how dates are formatted in the Company files list


### Paging

The search UI supports results paging (relevant for the plugin modes "Partner" and "Regulations") that can be configured using the `paging` array with a structure as follows:

- `paging`
    - `perPage` (integer, defaults to 20): number of results per page
    - `maximumPerPage` (integer, defaults to 1000): the maximum number of results to fetch from the data base
    - `detailPagePaging` (boolean, defaults to 1): if set to 1 this enables paging between detail pages
    - `menu`: an array of results per page options to be shown in a drop-down menu in the search UI.


Default settings and example:

```
	paging {
		perPage = 20
		maximumPerPage = 1000
		detailPagePaging = 1
		menu {
			0 = 5
			1 = 10
			2 = 20
			3 = 50
			4 = 100
		}
	}
```

### Sorting

Result sorting (relevant for the plugin modes "Partner" and "Regulations") can be influenced using the arrays `sort` and `sortOptions`.

- `sort`: An array with items of the following structure:
    - `id`: the ID of that sort option
    - `sortCriteria`: the actual sort configuration consisting of a property name and the sort order (either "asc" or "desc")
- `sortOptions`: UI-related settings
    - `menu`: an array that defines the sort options (see `sort`) to appear in a drop down list in the search UI
    - `selected`: Defines the sort option that is initially selected in the drop down list

Default settings and example:

```
	sort {
		0 {
			id = nameAsc
			sortCriteria = name asc
		}
		1 {
			id = nameDesc
			sortCriteria = name desc
		}
	}
	sortOptions {
		menu {
			0 = nameAsc
			1 = nameDesc
		}
		selected = nameAsc
	}
```


### E-mail notifications
The extension allows to send e-mail notifications when organization records have been created or removed via the frontend editor (relevant for plugin mode "Partner Editieransicht"), and in case files for a organization are uploaded or removed.

- `notification`:  An array with separate child arrays for each event type (currently `add`, `remove`, `fileadd`, and `fileremove`). Each of them supports these settings:
    - `enabled` (boolean, defaults to 0): enable or disable notifications for this event
    - `sender` (e-mail address): the e-mail address of the sender
    - `senderName`: the name of the sender
    - `to` (e-mail address): the e-mail address of the receiver
    - `toName`: the name of the receiver

Example:

```
	notification {
		add {
			enabled = 1
			sender = sender@example.org
			senderName = Sender
			to = receiver@example.com
			toName = Receiver
		}
		edit {
			enabled = 1
			sender = sender@example.org
			senderName = Sender
			to = receiver@example.com
			toName = Receiver
		}
	}
```

### Company listing

- `companyList`: configures the plugin mode "Neueste Partner" according to these settings:
    - `number` (integer, defaults to 6): the maximum number of Companies shown
    - `mode` (string, defaults to random): defines the listing mode. Valid modes are: random, latest
    
### Shared variables

Furthermore, the extension relies on certain **variables**, shared with the extension `mahu_frontend`, existing in the `lib` data structure.

- language settings
     - `lib.currentLangID`: the ID of the current language
     - `lib.currentLang`:  the name/code if the current language
