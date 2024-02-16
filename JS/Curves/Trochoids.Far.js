"use strict"

//Parameters

var title="Near Trochoids";
part="Parameters";

Setup[ part ][ "Values" ]=[1.0,1.25,1.5,1.75,2.0,2.25,2.5];


part="Curve";

Setup[ part ][ "Min" ]=[ t1,-4.0*scale*r ];
Setup[ part ][ "Max" ]=[ t2*r, 2.75*scale*r ];
