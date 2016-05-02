private function scrapePopulationsByState(){

        $cssSelector = "table.sk_popcharttable";

        $siteUrl = "http://www.ipl.org/div/stateknow/popchart.html";

        $tableXmlObject = pullXmlObjBlogExample($siteUrl,$cssSelector);

        $cnt = 0;

        foreach($tableXmlObject->tbody->tr as $tableRow){

            //the first two rows are the header and "All United States" rows so disregard

            if($cnt++ < 2)
                continue;

            //grab the state and population from the corresponding table cell of the row and output!

            $state = (string) $tableRow->td[1]->a;

            $population = (string) $tableRow->td[2];

            echo $state . " has a population of " . $population . "\n";

        }

}
