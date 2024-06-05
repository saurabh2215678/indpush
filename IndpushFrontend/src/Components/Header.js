import React from "react";
import { useSelector } from "react-redux";
import { Link } from "react-router-dom";
import styles from "./Header.module.css";

const Header = () => {
    const user = useSelector((state) => state.user.user);
    return (
        <header>
            <div className={styles.top_header}>
                <div className="py-2 px-7 bg_color">
                    <div className="d-flex container justify-content-between align-items-center">
                        <div className="tophead__wrapper d-flex">
                            <p className="d-xl-block d-lg-none">Reach out to us!</p>
                            <div className="tophead__wrapper__arrow d-xl-block d-lg-none">
                                <img src="https://larapush.com/assets/images/icons/arrow.svg" alt="arrow" />
                            </div>
                            <div className="tophead__links show-desktop">
                                <a title="Contact on Whatsapp" href="https://wa.me/919403891455?text=Hi%2C%20I%20am%20interested%20in%20LaraPush." target="_blank">
                                    <img src="https://larapush.com/assets/images/icons/icon-1.svg" height="30px" width="30px" alt="" />
                                </a>
                                <a href="https://join.skype.com/invite/uX1riqch60Ok" title="Join Skype" target="_blank">
                                    <img src="https://larapush.com/assets/images/icons/icon-3.svg" height="30px" width="30px" alt="" />
                                </a>
                                <a href="mailto:support@larapush.com" title="Send Email" target="_blank">
                                    <img src="https://larapush.com/assets/images/icons/icon-5.svg" height="30px" width="30px" alt="" />
                                </a>
                            </div>
                        </div>
                        <div className="d-flex flex-md-row justify-content-end">
                            <div className="text-right">
                                {/* <svg style="fill: rgba(8, 16, 77, 0.8)" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M15.5437 11.3062L12.0436 9.80614C11.8941 9.74242 11.728 9.72899 11.5701 9.76788C11.4123 9.80677 11.2714 9.89587 11.1686 10.0218L9.61861 11.9156C7.18598 10.7686 5.22828 8.81089 4.08132 6.37827L5.9751 4.82824C6.10126 4.72564 6.19054 4.58473 6.22945 4.42684C6.26836 4.26896 6.25477 4.10269 6.19073 3.95322L4.69071 0.453162C4.62043 0.292037 4.49613 0.160484 4.33925 0.0811864C4.18236 0.00188915 4.00273 -0.0201818 3.83132 0.0187795L0.58126 0.768793C0.415998 0.806955 0.26855 0.900007 0.162983 1.03276C0.0574151 1.16552 -3.80697e-05 1.33013 1.8926e-08 1.49974C1.8926e-08 9.51551 6.49699 16 14.5003 16C14.6699 16.0001 14.8346 15.9427 14.9674 15.8371C15.1002 15.7315 15.1933 15.5841 15.2315 15.4187L15.9815 12.1687C16.0202 11.9964 15.9977 11.8161 15.9178 11.6587C15.8379 11.5012 15.7056 11.3766 15.5437 11.3062Z"></path>
                        </svg> */}
                            </div>
                            <div className="mx-3 bold">
                                HOTLINE:
                            </div>
                            <a href="tel: +919403891455">
                                <div className="mx-3 bold">
                                    +91 9403891455 - <span className="country">INDIA</span>
                                </div>
                            </a>
                            <div className="mx-2 line">
                            </div>
                            <a href="tel: +13157074852">
                                <div className="ml-3 bold mr-0">
                                    +1 3157074852 - <span className="country">US</span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div className="container">
                <div className="d-flex justify-content-between py-4 align-items-center mb-4">
                    <Link to="/" className="d-block my-0 font-weight-normal logo" aria-label="Logo">
                        <img src="images/logo.png" style={{ width: "60%" }} alt="Logo" />
                    </Link>
                    <div className={styles.header_nav}>
                        <ul className="d-flex flex-wrap  mb-0 ps-0">
                            <li><Link to="/">Home</Link></li>
                            <li><a href="#Features">Features</a></li>
                            <li><a href="#Pricing">Pricing</a></li>
                            <li><a href="#Contact">Contact</a></li>
                            {user ?
                                <li><Link to="/dashboard">Dashboard</Link></li> :
                                <li><Link to="/login" className="text-white">Login</Link></li>
                            }
                        </ul>
                    </div>
                </div>
            </div>
        </header>
    )
}
export default Header;