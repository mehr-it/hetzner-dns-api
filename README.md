# Hetzner DNS API client
This library implements an unofficial but complete PHP client for the Hetzner Public DNS API.

## Why a proprietary license?
Since Hetzner responded with no interest in supporting the development of a PHP DNS API client 
library, we do not want to bear the development costs for the integration of their products alone. 
We are willing to share this package under MIT license, if the there is some kind of 
participation...

## Installation
You should use composer to install this library:

    composer require mehr-it/hetzner-dns-api
    
## Usage
Following example demonstrates the creation of a new DNS record. See the 
[official API docs](https://dns.hetzner.com/api-docs/) for a full list of operations. The
corresponding methods and parameters of the client class are named similar as in the
documentation.

    $apiToken = '...'; // see https://dns.hetzner.com/settings/api-token to generate one

    // create a client instance
    $client = new HetznerDnsClient($apiToken);
    
    // retrieve ID of the target zone
    $zoneId = $client->getZoneByName('mytestzone.de')->getZones()[0]->getId();

    // create new record
    $response = $client->createRecord(
        (new Record())
            ->zoneId($zoneId)
            ->ttl(900)
            ->type(Record::TYPE_A)
            ->value('8.8.8.8')
            ->name('www')
    );
    
    $recordId = $response->getRecord()->getId();

## Known issues
The Hetzner DNS API has some bugs. The bugs have been reported but 
yet not fixed for several months. The following functions are affected:

* getAllRecords (pagination seams not to work correctly)
* bulkUpdateRecords
* validateZoneFilePlain (valid records are not returned)
