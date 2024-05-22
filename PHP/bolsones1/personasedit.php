<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "personasinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$personas_edit = NULL; // Initialize page object first

class cpersonas_edit extends cpersonas {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{59F49AD3-C861-40D3-9DD1-F3603FE34B5B}";

	// Table name
	var $TableName = 'personas';

	// Page object name
	var $PageObjName = 'personas_edit';

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		if ($this->UseTokenInUrl) $PageUrl .= "t=" . $this->TableVar . "&"; // Add page token
		return $PageUrl;
	}

	// Message
	function getMessage() {
		return @$_SESSION[EW_SESSION_MESSAGE];
	}

	function setMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_MESSAGE], $v);
	}

	function getFailureMessage() {
		return @$_SESSION[EW_SESSION_FAILURE_MESSAGE];
	}

	function setFailureMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_FAILURE_MESSAGE], $v);
	}

	function getSuccessMessage() {
		return @$_SESSION[EW_SESSION_SUCCESS_MESSAGE];
	}

	function setSuccessMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_SUCCESS_MESSAGE], $v);
	}

	function getWarningMessage() {
		return @$_SESSION[EW_SESSION_WARNING_MESSAGE];
	}

	function setWarningMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_WARNING_MESSAGE], $v);
	}

	// Methods to clear message
	function ClearMessage() {
		$_SESSION[EW_SESSION_MESSAGE] = "";
	}

	function ClearFailureMessage() {
		$_SESSION[EW_SESSION_FAILURE_MESSAGE] = "";
	}

	function ClearSuccessMessage() {
		$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = "";
	}

	function ClearWarningMessage() {
		$_SESSION[EW_SESSION_WARNING_MESSAGE] = "";
	}

	function ClearMessages() {
		$_SESSION[EW_SESSION_MESSAGE] = "";
		$_SESSION[EW_SESSION_FAILURE_MESSAGE] = "";
		$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = "";
		$_SESSION[EW_SESSION_WARNING_MESSAGE] = "";
	}

	// Show message
	function ShowMessage() {
		$hidden = FALSE;
		$html = "";

		// Message
		$sMessage = $this->getMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sMessage, "");
		if ($sMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sMessage;
			$html .= "<div class=\"alert alert-info ewInfo\">" . $sMessage . "</div>";
			$_SESSION[EW_SESSION_MESSAGE] = ""; // Clear message in Session
		}

		// Warning message
		$sWarningMessage = $this->getWarningMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sWarningMessage, "warning");
		if ($sWarningMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sWarningMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sWarningMessage;
			$html .= "<div class=\"alert alert-warning ewWarning\">" . $sWarningMessage . "</div>";
			$_SESSION[EW_SESSION_WARNING_MESSAGE] = ""; // Clear message in Session
		}

		// Success message
		$sSuccessMessage = $this->getSuccessMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sSuccessMessage, "success");
		if ($sSuccessMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sSuccessMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sSuccessMessage;
			$html .= "<div class=\"alert alert-success ewSuccess\">" . $sSuccessMessage . "</div>";
			$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = ""; // Clear message in Session
		}

		// Failure message
		$sErrorMessage = $this->getFailureMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sErrorMessage, "failure");
		if ($sErrorMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sErrorMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sErrorMessage;
			$html .= "<div class=\"alert alert-danger ewError\">" . $sErrorMessage . "</div>";
			$_SESSION[EW_SESSION_FAILURE_MESSAGE] = ""; // Clear message in Session
		}
		echo "<div class=\"ewMessageDialog\"" . (($hidden) ? " style=\"display: none;\"" : "") . ">" . $html . "</div>";
	}
	var $PageHeader;
	var $PageFooter;

	// Show Page Header
	function ShowPageHeader() {
		$sHeader = $this->PageHeader;
		$this->Page_DataRendering($sHeader);
		if ($sHeader <> "") { // Header exists, display
			echo "<p>" . $sHeader . "</p>";
		}
	}

	// Show Page Footer
	function ShowPageFooter() {
		$sFooter = $this->PageFooter;
		$this->Page_DataRendered($sFooter);
		if ($sFooter <> "") { // Footer exists, display
			echo "<p>" . $sFooter . "</p>";
		}
	}

	// Validate page request
	function IsPageRequest() {
		global $objForm;
		if ($this->UseTokenInUrl) {
			if ($objForm)
				return ($this->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($this->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}
	var $Token = "";
	var $TokenTimeout = 0;
	var $CheckToken = EW_CHECK_TOKEN;
	var $CheckTokenFn = "ew_CheckToken";
	var $CreateTokenFn = "ew_CreateToken";

	// Valid Post
	function ValidPost() {
		if (!$this->CheckToken || !ew_IsHttpPost())
			return TRUE;
		if (!isset($_POST[EW_TOKEN_NAME]))
			return FALSE;
		$fn = $this->CheckTokenFn;
		if (is_callable($fn))
			return $fn($_POST[EW_TOKEN_NAME], $this->TokenTimeout);
		return FALSE;
	}

	// Create Token
	function CreateToken() {
		global $gsToken;
		if ($this->CheckToken) {
			$fn = $this->CreateTokenFn;
			if ($this->Token == "" && is_callable($fn)) // Create token
				$this->Token = $fn();
			$gsToken = $this->Token; // Save to global variable
		}
	}

	//
	// Page class constructor
	//
	function __construct() {
		global $conn, $Language;
		$GLOBALS["Page"] = &$this;
		$this->TokenTimeout = ew_SessionTimeoutTime();

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Parent constuctor
		parent::__construct();

		// Table object (personas)
		if (!isset($GLOBALS["personas"]) || get_class($GLOBALS["personas"]) == "cpersonas") {
			$GLOBALS["personas"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["personas"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'personas', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"])) $GLOBALS["gTimer"] = new cTimer();

		// Open connection
		if (!isset($conn)) $conn = ew_Connect($this->DBID);
	}

	//
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsCustomExport, $gsExportFile, $UserProfile, $Language, $Security, $objForm;

		// Create form object
		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->nombre->SetVisibility();
		$this->apellido->SetVisibility();
		$this->dni->SetVisibility();
		$this->padremadretutor->SetVisibility();
		$this->division->SetVisibility();
		$this->retirado->SetVisibility();
		$this->id_personas->SetVisibility();
		$this->id_personas->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();

		// Global Page Loading event (in userfn*.php)
		Page_Loading();

		// Page Load event
		$this->Page_Load();

		// Check token
		if (!$this->ValidPost()) {
			echo $Language->Phrase("InvalidPostRequest");
			$this->Page_Terminate();
			exit();
		}

		// Process auto fill
		if (@$_POST["ajax"] == "autofill") {
			$results = $this->GetAutoFill(@$_POST["name"], @$_POST["q"]);
			if ($results) {

				// Clean output buffer
				if (!EW_DEBUG_ENABLED && ob_get_length())
					ob_end_clean();
				echo $results;
				$this->Page_Terminate();
				exit();
			}
		}

		// Create Token
		$this->CreateToken();
	}

	//
	// Page_Terminate
	//
	function Page_Terminate($url = "") {
		global $gsExportFile, $gTmpImages;

		// Page Unload event
		$this->Page_Unload();

		// Global Page Unloaded event (in userfn*.php)
		Page_Unloaded();

		// Export
		global $EW_EXPORT, $personas;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($personas);
				$doc->Text = $sContent;
				if ($this->Export == "email")
					echo $this->ExportEmail($doc->Text);
				else
					$doc->Export();
				ew_DeleteTmpImages(); // Delete temp images
				exit();
			}
		}
		$this->Page_Redirecting($url);

		 // Close connection
		ew_CloseConn();

		// Go to URL if specified
		if ($url <> "") {
			if (!EW_DEBUG_ENABLED && ob_get_length())
				ob_end_clean();

			// Handle modal response
			if ($this->IsModal) {
				$row = array();
				$row["url"] = $url;
				echo ew_ArrayToJson(array($row));
			} else {
				header("Location: " . $url);
			}
		}
		exit();
	}
	var $FormClassName = "form-horizontal ewForm ewEditForm";
	var $IsModal = FALSE;
	var $DbMasterFilter;
	var $DbDetailFilter;

	// 
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError;
		global $gbSkipHeaderFooter;

		// Check modal
		$this->IsModal = (@$_GET["modal"] == "1" || @$_POST["modal"] == "1");
		if ($this->IsModal)
			$gbSkipHeaderFooter = TRUE;

		// Load key from QueryString
		if (@$_GET["id_personas"] <> "") {
			$this->id_personas->setQueryStringValue($_GET["id_personas"]);
		}

		// Process form if post back
		if (@$_POST["a_edit"] <> "") {
			$this->CurrentAction = $_POST["a_edit"]; // Get action code
			$this->LoadFormValues(); // Get form values
		} else {
			$this->CurrentAction = "I"; // Default action is display
		}

		// Check if valid key
		if ($this->id_personas->CurrentValue == "") {
			$this->Page_Terminate("personaslist.php"); // Invalid key, return to list
		}

		// Validate form if post back
		if (@$_POST["a_edit"] <> "") {
			if (!$this->ValidateForm()) {
				$this->CurrentAction = ""; // Form error, reset action
				$this->setFailureMessage($gsFormError);
				$this->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues();
			}
		}
		switch ($this->CurrentAction) {
			case "I": // Get a record to display
				if (!$this->LoadRow()) { // Load record based on key
					if ($this->getFailureMessage() == "") $this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
					$this->Page_Terminate("personaslist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$sReturnUrl = $this->getReturnUrl();
				if (ew_GetPageName($sReturnUrl) == "personaslist.php")
					$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to list page with correct master key if necessary
				$this->SendEmail = TRUE; // Send email on update success
				if ($this->EditRow()) { // Update record based on key
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Update success
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} elseif ($this->getFailureMessage() == $Language->Phrase("NoRecord")) {
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Restore form values if update failed
				}
		}

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Render the record
		$this->RowType = EW_ROWTYPE_EDIT; // Render as Edit
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Set up starting record parameters
	function SetUpStartRec() {
		if ($this->DisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->StartRec = $_GET[EW_TABLE_START_REC];
				$this->setStartRecordNumber($this->StartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$PageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($PageNo)) {
					$this->StartRec = ($PageNo-1)*$this->DisplayRecs+1;
					if ($this->StartRec <= 0) {
						$this->StartRec = 1;
					} elseif ($this->StartRec >= intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1) {
						$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1;
					}
					$this->setStartRecordNumber($this->StartRec);
				}
			}
		}
		$this->StartRec = $this->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->StartRec) || $this->StartRec == "") { // Avoid invalid start record counter
			$this->StartRec = 1; // Reset start record counter
			$this->setStartRecordNumber($this->StartRec);
		} elseif (intval($this->StartRec) > intval($this->TotalRecs)) { // Avoid starting record > total records
			$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to last page first record
			$this->setStartRecordNumber($this->StartRec);
		} elseif (($this->StartRec-1) % $this->DisplayRecs <> 0) {
			$this->StartRec = intval(($this->StartRec-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to page boundary
			$this->setStartRecordNumber($this->StartRec);
		}
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $Language;

		// Get upload data
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->nombre->FldIsDetailKey) {
			$this->nombre->setFormValue($objForm->GetValue("x_nombre"));
		}
		if (!$this->apellido->FldIsDetailKey) {
			$this->apellido->setFormValue($objForm->GetValue("x_apellido"));
		}
		if (!$this->dni->FldIsDetailKey) {
			$this->dni->setFormValue($objForm->GetValue("x_dni"));
		}
		if (!$this->padremadretutor->FldIsDetailKey) {
			$this->padremadretutor->setFormValue($objForm->GetValue("x_padremadretutor"));
		}
		if (!$this->division->FldIsDetailKey) {
			$this->division->setFormValue($objForm->GetValue("x_division"));
		}
		if (!$this->retirado->FldIsDetailKey) {
			$this->retirado->setFormValue($objForm->GetValue("x_retirado"));
		}
		if (!$this->id_personas->FldIsDetailKey)
			$this->id_personas->setFormValue($objForm->GetValue("x_id_personas"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadRow();
		$this->nombre->CurrentValue = $this->nombre->FormValue;
		$this->apellido->CurrentValue = $this->apellido->FormValue;
		$this->dni->CurrentValue = $this->dni->FormValue;
		$this->padremadretutor->CurrentValue = $this->padremadretutor->FormValue;
		$this->division->CurrentValue = $this->division->FormValue;
		$this->retirado->CurrentValue = $this->retirado->FormValue;
		$this->id_personas->CurrentValue = $this->id_personas->FormValue;
	}

	// Load row based on key values
	function LoadRow() {
		global $Security, $Language;
		$sFilter = $this->KeyFilter();

		// Call Row Selecting event
		$this->Row_Selecting($sFilter);

		// Load SQL based on filter
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$conn = &$this->Connection();
		$res = FALSE;
		$rs = ew_LoadRecordset($sSql, $conn);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->LoadRowValues($rs); // Load row values
			$rs->Close();
		}
		return $res;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		if (!$rs || $rs->EOF) return;

		// Call Row Selected event
		$row = &$rs->fields;
		$this->Row_Selected($row);
		$this->nombre->setDbValue($rs->fields('nombre'));
		$this->apellido->setDbValue($rs->fields('apellido'));
		$this->dni->setDbValue($rs->fields('dni'));
		$this->padremadretutor->setDbValue($rs->fields('padremadretutor'));
		$this->division->setDbValue($rs->fields('division'));
		$this->retirado->setDbValue($rs->fields('retirado'));
		$this->id_personas->setDbValue($rs->fields('id_personas'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->nombre->DbValue = $row['nombre'];
		$this->apellido->DbValue = $row['apellido'];
		$this->dni->DbValue = $row['dni'];
		$this->padremadretutor->DbValue = $row['padremadretutor'];
		$this->division->DbValue = $row['division'];
		$this->retirado->DbValue = $row['retirado'];
		$this->id_personas->DbValue = $row['id_personas'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// nombre
		// apellido
		// dni
		// padremadretutor
		// division
		// retirado
		// id_personas

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// nombre
		$this->nombre->ViewValue = $this->nombre->CurrentValue;
		$this->nombre->ViewCustomAttributes = "";

		// apellido
		$this->apellido->ViewValue = $this->apellido->CurrentValue;
		$this->apellido->ViewCustomAttributes = "";

		// dni
		$this->dni->ViewValue = $this->dni->CurrentValue;
		$this->dni->ViewCustomAttributes = "";

		// padremadretutor
		if (strval($this->padremadretutor->CurrentValue) <> "") {
			$this->padremadretutor->ViewValue = $this->padremadretutor->OptionCaption($this->padremadretutor->CurrentValue);
		} else {
			$this->padremadretutor->ViewValue = NULL;
		}
		$this->padremadretutor->ViewCustomAttributes = "";

		// division
		$this->division->ViewValue = $this->division->CurrentValue;
		$this->division->ViewCustomAttributes = "";

		// retirado
		if (strval($this->retirado->CurrentValue) <> "") {
			$this->retirado->ViewValue = $this->retirado->OptionCaption($this->retirado->CurrentValue);
		} else {
			$this->retirado->ViewValue = NULL;
		}
		$this->retirado->ViewCustomAttributes = "";

		// id_personas
		$this->id_personas->ViewValue = $this->id_personas->CurrentValue;
		$this->id_personas->ViewCustomAttributes = "";

			// nombre
			$this->nombre->LinkCustomAttributes = "";
			$this->nombre->HrefValue = "";
			$this->nombre->TooltipValue = "";

			// apellido
			$this->apellido->LinkCustomAttributes = "";
			$this->apellido->HrefValue = "";
			$this->apellido->TooltipValue = "";

			// dni
			$this->dni->LinkCustomAttributes = "";
			$this->dni->HrefValue = "";
			$this->dni->TooltipValue = "";

			// padremadretutor
			$this->padremadretutor->LinkCustomAttributes = "";
			$this->padremadretutor->HrefValue = "";
			$this->padremadretutor->TooltipValue = "";

			// division
			$this->division->LinkCustomAttributes = "";
			$this->division->HrefValue = "";
			$this->division->TooltipValue = "";

			// retirado
			$this->retirado->LinkCustomAttributes = "";
			$this->retirado->HrefValue = "";
			$this->retirado->TooltipValue = "";

			// id_personas
			$this->id_personas->LinkCustomAttributes = "";
			$this->id_personas->HrefValue = "";
			$this->id_personas->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// nombre
			$this->nombre->EditAttrs["class"] = "form-control";
			$this->nombre->EditCustomAttributes = "";
			$this->nombre->EditValue = ew_HtmlEncode($this->nombre->CurrentValue);
			$this->nombre->PlaceHolder = ew_RemoveHtml($this->nombre->FldCaption());

			// apellido
			$this->apellido->EditAttrs["class"] = "form-control";
			$this->apellido->EditCustomAttributes = "";
			$this->apellido->EditValue = ew_HtmlEncode($this->apellido->CurrentValue);
			$this->apellido->PlaceHolder = ew_RemoveHtml($this->apellido->FldCaption());

			// dni
			$this->dni->EditAttrs["class"] = "form-control";
			$this->dni->EditCustomAttributes = "";
			$this->dni->EditValue = ew_HtmlEncode($this->dni->CurrentValue);
			$this->dni->PlaceHolder = ew_RemoveHtml($this->dni->FldCaption());

			// padremadretutor
			$this->padremadretutor->EditCustomAttributes = "";
			$this->padremadretutor->EditValue = $this->padremadretutor->Options(FALSE);

			// division
			$this->division->EditAttrs["class"] = "form-control";
			$this->division->EditCustomAttributes = "";
			$this->division->EditValue = ew_HtmlEncode($this->division->CurrentValue);
			$this->division->PlaceHolder = ew_RemoveHtml($this->division->FldCaption());

			// retirado
			$this->retirado->EditCustomAttributes = "";
			$this->retirado->EditValue = $this->retirado->Options(FALSE);

			// id_personas
			$this->id_personas->EditAttrs["class"] = "form-control";
			$this->id_personas->EditCustomAttributes = "";
			$this->id_personas->EditValue = $this->id_personas->CurrentValue;
			$this->id_personas->ViewCustomAttributes = "";

			// Edit refer script
			// nombre

			$this->nombre->LinkCustomAttributes = "";
			$this->nombre->HrefValue = "";

			// apellido
			$this->apellido->LinkCustomAttributes = "";
			$this->apellido->HrefValue = "";

			// dni
			$this->dni->LinkCustomAttributes = "";
			$this->dni->HrefValue = "";

			// padremadretutor
			$this->padremadretutor->LinkCustomAttributes = "";
			$this->padremadretutor->HrefValue = "";

			// division
			$this->division->LinkCustomAttributes = "";
			$this->division->HrefValue = "";

			// retirado
			$this->retirado->LinkCustomAttributes = "";
			$this->retirado->HrefValue = "";

			// id_personas
			$this->id_personas->LinkCustomAttributes = "";
			$this->id_personas->HrefValue = "";
		}
		if ($this->RowType == EW_ROWTYPE_ADD ||
			$this->RowType == EW_ROWTYPE_EDIT ||
			$this->RowType == EW_ROWTYPE_SEARCH) { // Add / Edit / Search row
			$this->SetupFieldTitles();
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	// Validate form
	function ValidateForm() {
		global $Language, $gsFormError;

		// Initialize form error message
		$gsFormError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if (!$this->nombre->FldIsDetailKey && !is_null($this->nombre->FormValue) && $this->nombre->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->nombre->FldCaption(), $this->nombre->ReqErrMsg));
		}
		if (!$this->apellido->FldIsDetailKey && !is_null($this->apellido->FormValue) && $this->apellido->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->apellido->FldCaption(), $this->apellido->ReqErrMsg));
		}
		if (!$this->dni->FldIsDetailKey && !is_null($this->dni->FormValue) && $this->dni->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->dni->FldCaption(), $this->dni->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->dni->FormValue)) {
			ew_AddMessage($gsFormError, $this->dni->FldErrMsg());
		}
		if ($this->padremadretutor->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->padremadretutor->FldCaption(), $this->padremadretutor->ReqErrMsg));
		}
		if (!$this->division->FldIsDetailKey && !is_null($this->division->FormValue) && $this->division->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->division->FldCaption(), $this->division->ReqErrMsg));
		}
		if ($this->retirado->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->retirado->FldCaption(), $this->retirado->ReqErrMsg));
		}

		// Return validate result
		$ValidateForm = ($gsFormError == "");

		// Call Form_CustomValidate event
		$sFormCustomError = "";
		$ValidateForm = $ValidateForm && $this->Form_CustomValidate($sFormCustomError);
		if ($sFormCustomError <> "") {
			ew_AddMessage($gsFormError, $sFormCustomError);
		}
		return $ValidateForm;
	}

	// Update record based on key values
	function EditRow() {
		global $Security, $Language;
		$sFilter = $this->KeyFilter();
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$conn = &$this->Connection();
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE)
			return FALSE;
		if ($rs->EOF) {
			$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
			$EditRow = FALSE; // Update Failed
		} else {

			// Save old values
			$rsold = &$rs->fields;
			$this->LoadDbValues($rsold);
			$rsnew = array();

			// nombre
			$this->nombre->SetDbValueDef($rsnew, $this->nombre->CurrentValue, "", $this->nombre->ReadOnly);

			// apellido
			$this->apellido->SetDbValueDef($rsnew, $this->apellido->CurrentValue, "", $this->apellido->ReadOnly);

			// dni
			$this->dni->SetDbValueDef($rsnew, $this->dni->CurrentValue, 0, $this->dni->ReadOnly);

			// padremadretutor
			$this->padremadretutor->SetDbValueDef($rsnew, $this->padremadretutor->CurrentValue, "", $this->padremadretutor->ReadOnly);

			// division
			$this->division->SetDbValueDef($rsnew, $this->division->CurrentValue, "", $this->division->ReadOnly);

			// retirado
			$this->retirado->SetDbValueDef($rsnew, $this->retirado->CurrentValue, 0, $this->retirado->ReadOnly);

			// Call Row Updating event
			$bUpdateRow = $this->Row_Updating($rsold, $rsnew);
			if ($bUpdateRow) {
				$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
				if (count($rsnew) > 0)
					$EditRow = $this->Update($rsnew, "", $rsold);
				else
					$EditRow = TRUE; // No field to update
				$conn->raiseErrorFn = '';
				if ($EditRow) {
				}
			} else {
				if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

					// Use the message, do nothing
				} elseif ($this->CancelMessage <> "") {
					$this->setFailureMessage($this->CancelMessage);
					$this->CancelMessage = "";
				} else {
					$this->setFailureMessage($Language->Phrase("UpdateCancelled"));
				}
				$EditRow = FALSE;
			}
		}

		// Call Row_Updated event
		if ($EditRow)
			$this->Row_Updated($rsold, $rsnew);
		$rs->Close();
		return $EditRow;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("personaslist.php"), "", $this->TableVar, TRUE);
		$PageId = "edit";
		$Breadcrumb->Add("edit", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		}
	}

	// Setup AutoSuggest filters of a field
	function SetupAutoSuggestFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		}
	}

	// Page Load event
	function Page_Load() {

		//echo "Page Load";
	}

	// Page Unload event
	function Page_Unload() {

		//echo "Page Unload";
	}

	// Page Redirecting event
	function Page_Redirecting(&$url) {

		// Example:
		//$url = "your URL";

	}

	// Message Showing event
	// $type = ''|'success'|'failure'|'warning'
	function Message_Showing(&$msg, $type) {
		if ($type == 'success') {

			//$msg = "your success message";
		} elseif ($type == 'failure') {

			//$msg = "your failure message";
		} elseif ($type == 'warning') {

			//$msg = "your warning message";
		} else {

			//$msg = "your message";
		}
	}

	// Page Render event
	function Page_Render() {

		//echo "Page Render";
	}

	// Page Data Rendering event
	function Page_DataRendering(&$header) {

		// Example:
		//$header = "your header";

	}

	// Page Data Rendered event
	function Page_DataRendered(&$footer) {

		// Example:
		//$footer = "your footer";

	}

	// Form Custom Validate event
	function Form_CustomValidate(&$CustomError) {

		// Return error message in CustomError
		return TRUE;
	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($personas_edit)) $personas_edit = new cpersonas_edit();

// Page init
$personas_edit->Page_Init();

// Page main
$personas_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$personas_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = fpersonasedit = new ew_Form("fpersonasedit", "edit");

// Validate form
fpersonasedit.Validate = function() {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	var $ = jQuery, fobj = this.GetForm(), $fobj = $(fobj);
	if ($fobj.find("#a_confirm").val() == "F")
		return true;
	var elm, felm, uelm, addcnt = 0;
	var $k = $fobj.find("#" + this.FormKeyCountName); // Get key_count
	var rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1;
	var startcnt = (rowcnt == 0) ? 0 : 1; // Check rowcnt == 0 => Inline-Add
	var gridinsert = $fobj.find("#a_list").val() == "gridinsert";
	for (var i = startcnt; i <= rowcnt; i++) {
		var infix = ($k[0]) ? String(i) : "";
		$fobj.data("rowindex", infix);
			elm = this.GetElements("x" + infix + "_nombre");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $personas->nombre->FldCaption(), $personas->nombre->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_apellido");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $personas->apellido->FldCaption(), $personas->apellido->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_dni");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $personas->dni->FldCaption(), $personas->dni->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_dni");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($personas->dni->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_padremadretutor");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $personas->padremadretutor->FldCaption(), $personas->padremadretutor->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_division");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $personas->division->FldCaption(), $personas->division->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_retirado");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $personas->retirado->FldCaption(), $personas->retirado->ReqErrMsg)) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
	}

	// Process detail forms
	var dfs = $fobj.find("input[name='detailpage']").get();
	for (var i = 0; i < dfs.length; i++) {
		var df = dfs[i], val = df.value;
		if (val && ewForms[val])
			if (!ewForms[val].Validate())
				return false;
	}
	return true;
}

// Form_CustomValidate event
fpersonasedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fpersonasedit.ValidateRequired = true;
<?php } else { ?>
fpersonasedit.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fpersonasedit.Lists["x_padremadretutor"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fpersonasedit.Lists["x_padremadretutor"].Options = <?php echo json_encode($personas->padremadretutor->Options()) ?>;
fpersonasedit.Lists["x_retirado"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fpersonasedit.Lists["x_retirado"].Options = <?php echo json_encode($personas->retirado->Options()) ?>;

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$personas_edit->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $personas_edit->ShowPageHeader(); ?>
<?php
$personas_edit->ShowMessage();
?>
<form name="fpersonasedit" id="fpersonasedit" class="<?php echo $personas_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($personas_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $personas_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="personas">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<?php if ($personas_edit->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($personas->nombre->Visible) { // nombre ?>
	<div id="r_nombre" class="form-group">
		<label id="elh_personas_nombre" for="x_nombre" class="col-sm-2 control-label ewLabel"><?php echo $personas->nombre->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $personas->nombre->CellAttributes() ?>>
<span id="el_personas_nombre">
<input type="text" data-table="personas" data-field="x_nombre" name="x_nombre" id="x_nombre" size="30" maxlength="20" placeholder="<?php echo ew_HtmlEncode($personas->nombre->getPlaceHolder()) ?>" value="<?php echo $personas->nombre->EditValue ?>"<?php echo $personas->nombre->EditAttributes() ?>>
</span>
<?php echo $personas->nombre->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($personas->apellido->Visible) { // apellido ?>
	<div id="r_apellido" class="form-group">
		<label id="elh_personas_apellido" for="x_apellido" class="col-sm-2 control-label ewLabel"><?php echo $personas->apellido->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $personas->apellido->CellAttributes() ?>>
<span id="el_personas_apellido">
<input type="text" data-table="personas" data-field="x_apellido" name="x_apellido" id="x_apellido" size="30" maxlength="20" placeholder="<?php echo ew_HtmlEncode($personas->apellido->getPlaceHolder()) ?>" value="<?php echo $personas->apellido->EditValue ?>"<?php echo $personas->apellido->EditAttributes() ?>>
</span>
<?php echo $personas->apellido->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($personas->dni->Visible) { // dni ?>
	<div id="r_dni" class="form-group">
		<label id="elh_personas_dni" for="x_dni" class="col-sm-2 control-label ewLabel"><?php echo $personas->dni->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $personas->dni->CellAttributes() ?>>
<span id="el_personas_dni">
<input type="text" data-table="personas" data-field="x_dni" name="x_dni" id="x_dni" size="30" placeholder="<?php echo ew_HtmlEncode($personas->dni->getPlaceHolder()) ?>" value="<?php echo $personas->dni->EditValue ?>"<?php echo $personas->dni->EditAttributes() ?>>
</span>
<?php echo $personas->dni->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($personas->padremadretutor->Visible) { // padremadretutor ?>
	<div id="r_padremadretutor" class="form-group">
		<label id="elh_personas_padremadretutor" class="col-sm-2 control-label ewLabel"><?php echo $personas->padremadretutor->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $personas->padremadretutor->CellAttributes() ?>>
<span id="el_personas_padremadretutor">
<div id="tp_x_padremadretutor" class="ewTemplate"><input type="radio" data-table="personas" data-field="x_padremadretutor" data-value-separator="<?php echo $personas->padremadretutor->DisplayValueSeparatorAttribute() ?>" name="x_padremadretutor" id="x_padremadretutor" value="{value}"<?php echo $personas->padremadretutor->EditAttributes() ?>></div>
<div id="dsl_x_padremadretutor" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $personas->padremadretutor->RadioButtonListHtml(FALSE, "x_padremadretutor") ?>
</div></div>
</span>
<?php echo $personas->padremadretutor->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($personas->division->Visible) { // division ?>
	<div id="r_division" class="form-group">
		<label id="elh_personas_division" for="x_division" class="col-sm-2 control-label ewLabel"><?php echo $personas->division->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $personas->division->CellAttributes() ?>>
<span id="el_personas_division">
<input type="text" data-table="personas" data-field="x_division" name="x_division" id="x_division" size="30" maxlength="2" placeholder="<?php echo ew_HtmlEncode($personas->division->getPlaceHolder()) ?>" value="<?php echo $personas->division->EditValue ?>"<?php echo $personas->division->EditAttributes() ?>>
</span>
<?php echo $personas->division->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($personas->retirado->Visible) { // retirado ?>
	<div id="r_retirado" class="form-group">
		<label id="elh_personas_retirado" class="col-sm-2 control-label ewLabel"><?php echo $personas->retirado->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $personas->retirado->CellAttributes() ?>>
<span id="el_personas_retirado">
<div id="tp_x_retirado" class="ewTemplate"><input type="radio" data-table="personas" data-field="x_retirado" data-value-separator="<?php echo $personas->retirado->DisplayValueSeparatorAttribute() ?>" name="x_retirado" id="x_retirado" value="{value}"<?php echo $personas->retirado->EditAttributes() ?>></div>
<div id="dsl_x_retirado" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $personas->retirado->RadioButtonListHtml(FALSE, "x_retirado") ?>
</div></div>
</span>
<?php echo $personas->retirado->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($personas->id_personas->Visible) { // id_personas ?>
	<div id="r_id_personas" class="form-group">
		<label id="elh_personas_id_personas" class="col-sm-2 control-label ewLabel"><?php echo $personas->id_personas->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $personas->id_personas->CellAttributes() ?>>
<span id="el_personas_id_personas">
<span<?php echo $personas->id_personas->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $personas->id_personas->EditValue ?></p></span>
</span>
<input type="hidden" data-table="personas" data-field="x_id_personas" name="x_id_personas" id="x_id_personas" value="<?php echo ew_HtmlEncode($personas->id_personas->CurrentValue) ?>">
<?php echo $personas->id_personas->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php if (!$personas_edit->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $personas_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
fpersonasedit.Init();
</script>
<?php
$personas_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$personas_edit->Page_Terminate();
?>
