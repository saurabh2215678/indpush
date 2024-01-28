import React, { useEffect, useState } from 'react'
import { apiURI } from '../utils/common'
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
                                <th>Domain</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            {
                                plugins.map((item, index)=>
                                <tr key={index}>
                                    <td>{item.name}</td>
                                    <td>{item.email}</td>
                                    <td>{item.user_domain}</td>
                                    <td>
                                        <span className="badge text-bg-success">
                                            {item.status}
                                        </span>
                                    </td>

                                </tr>
                                )
                            }

                            {/* <tr>
                                <td>July 2, 2023</td>
                                <td>10:42 AM</td>
                                <td>Food Delivery</td>
                                <td>Mobile Reload</td>
                                <td className="text-success">
                                    <span className="me-1">+</span>
                                    $250
                                </td>
                                <td>$5,600.00</td>
                                <td>
                                    <span className="badge text-bg-success">
                                        Success
                                    </span>
                                </td>
                            </tr> */}
                            
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