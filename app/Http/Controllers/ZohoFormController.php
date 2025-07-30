<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Services\ZohoService;

use com\zoho\crm\api\record\Record;
use com\zoho\crm\api\record\Field;
use com\zoho\crm\api\record\RecordOperations;
use com\zoho\crm\api\record\BodyWrapper;
use com\zoho\crm\api\util\Choice;


class ZohoFormController extends Controller
{
    protected $zoho;

    public function __construct(ZohoService $zoho) {
        $this->zoho = $zoho;
    }
    /**
     * Display the Zoho form.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        return Inertia::render('Zoho/Form');
    }

    /**
     * Handle the form submission and store data in Zoho CRM.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */


   public function store(Request $request)
{
    // Validate input
    $data = $request->validate([
        'account_name' => 'required|string|max:255',
        'account_phone' => 'nullable|string|max:50',
        'account_website' => 'nullable|url|max:255',
        'deal_name' => 'required|string|max:255',
        'stage' => 'required|string|max:50',
    ]);

    // Initialize Zoho SDK
    ZohoService::initialize();

    try {
        $recordOps = new RecordOperations("Accounts");

        // Create Account
        $account = new Record();
        $account->addFieldValue(new Field('Account_Name'), $data['account_name']);

        if (!empty($data['account_phone'])) {
            $account->addFieldValue(new Field('Phone'), $data['account_phone']);
        }

        if (!empty($data['account_website'])) {
            $account->addFieldValue(new Field('Website'), $data['account_website']);
        }

        $accountBody = new BodyWrapper();
        $accountBody->setData([$account]);

        $accountResponse = $recordOps->createRecords($accountBody);
        $accountDetails = $accountResponse->getObject()->getData()[0];
        $accountId = $accountDetails->getDetails()['id'];

        // Create Deal
        $recordOps = new RecordOperations("Deals");
        $deal = new Record();
        $deal->addFieldValue(new Field('Deal_Name'), $data['deal_name']);
        $deal->addFieldValue(new Field('Stage'), new Choice($data['stage']));

        // Link Deal to Account by passing Record with ID
        $accountRef = new Record();
        $accountRef->setId($accountId);
        $deal->addFieldValue(new Field('Account_Name'), $accountRef);

        $dealBody = new BodyWrapper();
        $dealBody->setData([$deal]);

        $dealResponse = $recordOps->createRecords($dealBody);

        return back()->with('success', 'Account and Deal created successfully.');
    } catch (\Exception $e) {
        return back()->withErrors('Error while creating records in Zoho CRM: ' . $e->getMessage());
    }
}
}
