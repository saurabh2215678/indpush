import React, { useEffect, useState } from 'react'
import { apiURI, getExtraData } from '../utils/common'
function MasterAdmin() {

    const [plugins, setPlugins] = useState([]);

    async function fetchApi() {
        const URL = apiURI+ '/get-plugin-list';
        const response = await fetch(URL,{
            method:'post',
            headers: {
                "Content-Type": "application/x-www-form-urlencoded",
                }
        });
        const data = await response.json();
        console.log(data);
        setPlugins(data);
    }

    useEffect(()=>{
         fetchApi();

    },[])
  return (
    <main className="main-wrapper col-md-9 ms-sm-auto py-4 col-lg-9 px-md-4 border-start">
    <div className="title-group mb-3">
        <h1 className="h2 mb-0">Overviews</h1>

        
    </div>
        <div className='row my-4'>
            <div className='col-lg-12 col-12'>
                <div className='custom-block bg-white'>
                    <h5 className="mb-4">Plugin Activities</h5>
                    <div className='table-responsive'>
                        <table className='account-table table'>
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                {/* <th>Domain</th> */}
                                <th>Status</th>
                                <th>Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            {
                                plugins.map((item, index)=>
                                <tr key={index}>
                                    <td>{item.name}</td>
                                    <td>{item.email}</td>
                                    {/* <td>{getExtraData('domain', item.extra_data)}</td> */}
                                    <td>
                                        <span className="badge text-bg-success">
                                            {item.status}
                                        </span>
                                    </td>
                                    <td>{item.from_now}</td>
                                </tr>
                                )
                            }

                            
                            
                        </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>
  )
}

export default MasterAdmin