import React from 'react'

function MasterAdmin() {
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
                                <th>Date</th>
                                <th>Time</th>
                                <th>Description</th>
                                <th>Payment Type</th>
                                <th>Amount</th>
                                <th>Balance</th>
                                <th>Status</th>

                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                            <td>July 5, 2023</td>
                            <td>10:00 PM</td>
                            <td>Shopping</td>
                            <td>C2C Transfer</td>
                            <td className="text-danger">
                            <span className="me-1">-</span>
                            $100.00
                            </td>
                            <td>$5,500.00</td>
                            <td>
                            <span className="badge text-bg-danger">
                            Pending
                            </span>
                            </td>
                            </tr>
                            <tr>
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
                            </tr>
                            <tr>
                            <td>July 5, 2023</td>
                            <td>10:00 PM</td>
                            <td>Shopping</td>
                            <td>C2C Transfer</td>
                            <td className="text-danger">
                            <span className="me-1">-</span>
                            $100.00
                            </td>
                            <td>$5,500.00</td>
                            <td>
                            <span className="badge text-bg-danger">
                            Pending
                            </span>
                            </td>
                            </tr>
                            <tr>
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

export default MasterAdmin