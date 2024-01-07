import React from 'react'

function Dashboard() {
  return (
    <main className="main-wrapper col-md-9 ms-sm-auto py-4 col-lg-9 px-md-4 border-start">
                    <div className="title-group mb-3">
                        <h1 className="h2 mb-0">Overviews</h1>

                        
                    </div>
                        <div className='row my-4'>
                            <div className='col-lg-12 col-12'>
                                <div className='custom-block bg-white'>
                                    <h5 className="mb-4">Account Activities</h5>
                                    <div className='table-responsive'>
                                        <table className='account-table table'>
                                        <thead>
                                            <tr>
                                                <th scope="col">Date</th>
                                                <th scope="col">Time</th>
                                                <th scope="col">Description</th>
                                                <th scope="col">Payment Type</th>
                                                <th scope="col">Amount</th>
                                                <th scope="col">Balance</th>
                                                <th scope="col">Status</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                            <td scope="row">July 5, 2023</td>
                                            <td scope="row">10:00 PM</td>
                                            <td scope="row">Shopping</td>
                                            <td scope="row">C2C Transfer</td>
                                            <td className="text-danger" scope="row">
                                            <span className="me-1">-</span>
                                            $100.00
                                            </td>
                                            <td scope="row">$5,500.00</td>
                                            <td scope="row">
                                            <span className="badge text-bg-danger">
                                            Pending
                                            </span>
                                            </td>
                                            </tr>
                                            <tr>
                                                <td scope="row">July 2, 2023</td>
                                                <td scope="row">10:42 AM</td>
                                                <td scope="row">Food Delivery</td>
                                                <td scope="row">Mobile Reload</td>
                                                <td className="text-success" scope="row">
                                                    <span className="me-1">+</span>
                                                    $250
                                                </td>
                                                <td scope="row">$5,600.00</td>
                                                <td scope="row">
                                                    <span className="badge text-bg-success">
                                                        Success
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                            <td scope="row">July 5, 2023</td>
                                            <td scope="row">10:00 PM</td>
                                            <td scope="row">Shopping</td>
                                            <td scope="row">C2C Transfer</td>
                                            <td className="text-danger" scope="row">
                                            <span className="me-1">-</span>
                                            $100.00
                                            </td>
                                            <td scope="row">$5,500.00</td>
                                            <td scope="row">
                                            <span className="badge text-bg-danger">
                                            Pending
                                            </span>
                                            </td>
                                            </tr>
                                            <tr>
                                                <td scope="row">July 2, 2023</td>
                                                <td scope="row">10:42 AM</td>
                                                <td scope="row">Food Delivery</td>
                                                <td scope="row">Mobile Reload</td>
                                                <td className="text-success" scope="row">
                                                    <span className="me-1">+</span>
                                                    $250
                                                </td>
                                                <td scope="row">$5,600.00</td>
                                                <td scope="row">
                                                    <span className="badge text-bg-success">
                                                        Success
                                                    </span>
                                                </td>
                                            </tr>
                                            
                                        </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </main>
  )
}

export default Dashboard