import React from 'react'
import { useSelector } from 'react-redux'
import { Link } from 'react-router-dom'



function Nav() {
    const user = useSelector((state) => state.user.user)
    
  return (
    <div>
         <header className="navbar sticky-top flex-md-nowrap">
            <div className="col-md-3 col-lg-3 me-0 px-3 fs-6">
                <Link className="navbar-brand" to="/">
                    <i className="bi-box"></i>
                    IndPush
                </Link>
            </div>

            <button className="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
                <span className="navbar-toggler-icon"></span>
            </button>

           
            <div className="navbar-nav me-lg-2">
                <div className="nav-item text-nowrap d-flex align-items-center">
                <div className="dropdown ps-3">
                        <a className="nav-link dropdown-toggle text-center" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" id="navbarLightDropdownMenuLink">
                            <i className="bi-bell"></i>
                            <span className="position-absolute start-100 translate-middle p-1 bg-danger border border-light rounded-circle">
                                <span className="visually-hidden">New alerts</span>
                            </span>
                        </a>

                        <ul className="dropdown-menu dropdown-menu-lg-end notifications-block-wrap bg-white shadow" aria-labelledby="navbarLightDropdownMenuLink">
                            <small>Notifications</small>

                            <li className="notifications-block border-bottom pb-2 mb-2">
                                <a className="dropdown-item d-flex  align-items-center" href="#">
                                    <div className="notifications-icon-wrap bg-success">
                                        <i className="notifications-icon bi-check-circle-fill"></i>
                                    </div>

                                    <div>
                                        <span>Your account has been created successfuly.</span>

                                        <p>12 days ago</p>
                                    </div>
                                </a>
                            </li>

                            <li className="notifications-block border-bottom pb-2 mb-2">
                                <a className="dropdown-item d-flex align-items-center" href="#">
                                    <div className="notifications-icon-wrap bg-info">
                                        <i className="notifications-icon bi-folder"></i>
                                    </div>

                                    <div>
                                        <span>Please check. We have sent a Daily report.</span>

                                        <p>10 days ago</p>
                                    </div>
                                </a>
                            </li>

                            <li className="notifications-block">
                                <a className="dropdown-item d-flex align-items-center" href="#">
                                    <div className="notifications-icon-wrap bg-danger">
                                        <i className="notifications-icon bi-question-circle"></i>
                                    </div>

                                    <div>
                                        <span>Account verification failed.</span>

                                        <p>1 hour ago</p>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>

                   

                    <div className="dropdown px-3">
                    <Link to="/login" className="nav-link dropdown-toggle">
                    <img
                            src="/images/social/medium-shot-happy-man-smiling.jpg"
                            className="profile-image img-fluid"
                            alt=""
                            />
                            {user?.name}
                            
                    </Link>
                        {/* <a className="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="images/medium-shot-happy-man-smiling.jpg" className="profile-image img-fluid" alt="">
                            <img
                            src="/images/social/medium-shot-happy-man-smiling.jpg"
                            className="profile-image img-fluid"
                            alt=""
                            />
                        </a> */}
                        <ul className="dropdown-menu bg-white shadow">
                            <li>
                                <div className="dropdown-menu-profile-thumb d-flex">
                                    {/* <img src="images/medium-shot-happy-man-smiling.jpg" className="profile-image img-fluid me-3" alt=""> */}

                                    <div className="d-flex flex-column">
                                        <small>Thomas</small>
                                        <a href="#">thomas@site.com</a>
                                    </div>
                                </div>
                            </li>

                            <li>
                                <a className="dropdown-item" href="profile.html">
                                    <i className="bi-person me-2"></i>
                                    Profile
                                </a>
                            </li>

                            <li>
                                <a className="dropdown-item" href="setting.html">
                                    <i className="bi-gear me-2"></i>
                                    Settings
                                </a>
                            </li>

                            <li>
                                <a className="dropdown-item" href="help-center.html">
                                    <i className="bi-question-circle me-2"></i>
                                    Help
                                </a>
                            </li>

                            <li className="border-top mt-3 pt-2 mx-4">
                                <a className="dropdown-item ms-0 me-0" href="#">
                                    <i className="bi-box-arrow-left me-2"></i>
                                    Logout
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </header>
    </div>
  )
}

export default Nav