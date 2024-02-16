"use strict";
function Hash(hash)
{
    let new_hash={};
    for (let key in hash)
    {
        new_hash[ key ]=hash[ key ];
    }
    
    return new_hash;
}

//
// Merge hashes - shallow copy.
//


function Hashes_Merge(hash1,hash2={})
{
    let hash3={};
    for (let key in hash1)
    {
        hash3[ key ]=hash1[ key ];
    }
    for (let key in hash2)
    {
        hash3[ key ]=hash2[ key ];
    }
    
    return hash3;
}
