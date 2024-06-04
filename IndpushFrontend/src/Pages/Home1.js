import React from "react";
import { Link } from "react-router-dom";
import styles from "../App.css";

const Home = () => {
    return (
        <>
            <div className="phone" style={{ position: "fixed", top: 0, left: 0, width: "100%", zIndex: 9999 }}>
                <div className="py-2 px-7" style={{ height: "50px", background: "#f6faff" }}>
                    <div className="d-flex container justify-content-between align-items-center" style={{ height: "100%", fontSize: "14px" }}>
                        <div className="tophead__wrapper d-flex">
                            <p className="d-xl-block d-lg-none">Reach out to us!</p>
                            <div className="tophead__wrapper__arrow d-xl-block d-lg-none">
                                <img src="../images/icons/arrow.svg" alt="arrow" />
                            </div>
                            <div className="tophead__links show-desktop">
                                <a title="Contact on Whatsapp" href="https://wa.me/919999999999?text=Hi%2C%20I%20am%20interested%20in%20LaraPush." target="_blank" rel="noopener noreferrer">
                                    <img src="../images/icons/icon-1.svg" height="30px" width="30px" alt="" />
                                </a>
                                <a href="https://join.skype.com/invite/uX1riqch60Ok" title="Join Skype" target="_blank" rel="noopener noreferrer">
                                    <img src="../images/icons/icon-3.svg" height="30px" width="30px" alt="" />
                                </a>
                                <a href="mailto:support@larapush.com" title="Send Email" target="_blank" rel="noopener noreferrer">
                                    <img src="../images/icons/icon-5.svg" height="30px" width="30px" alt="" />
                                </a>
                            </div>
                        </div>
                        <div className="d-flex flex-md-row justify-content-end">
                            <div className="text-right">
                                <svg style={{ fill: "rgba(8, 16, 77, 0.8)" }} width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M15.5437 11.3062L12.0436 9.80614C11.8941 9.74242 11.728 9.72899 11.5701 9.76788C11.4123 9.80677 11.2714 9.89587 11.1686 10.0218L9.61861 11.9156C7.18598 10.7686 5.22828 8.81089 4.08132 6.37827L5.9751 4.82824C6.10126 4.72564 6.19054 4.58473 6.22945 4.42684C6.26836 4.26896 6.25477 4.10269 6.19073 3.95322L4.69071 0.453162C4.62043 0.292037 4.49613 0.160484 4.33925 0.0811864C4.18236 0.00188915 4.00273 -0.0201818 3.83132 0.0187795L0.58126 0.768793C0.415998 0.806955 0.26855 0.900007 0.162983 1.03276C0.0574151 1.16552 -3.80697e-05 1.33013 1.8926e-08 1.49974C1.8926e-08 9.51551 6.49699 16 14.5003 16C14.6699 16.0001 14.8346 15.9427 14.9674 15.8371C15.1002 15.7315 15.1933 15.5841 15.2315 15.4187L15.9815 12.1687C16.0202 11.9964 15.9977 11.8161 15.9178 11.6587C15.8379 11.5012 15.7056 11.3766 15.5437 11.3062Z"></path>
                                </svg>
                            </div>
                            <div className="mx-3 bold">
                                HOTLINE:
                            </div>
                            <a href="tel:+919999999999">
                                <div className="mx-3 bold">
                                    +91 9999999999 - <span className="country">INDIA</span>
                                </div>
                            </a>
                            <div className="mx-2 line" style={{ height: "20px" }}></div>
                            <a href="tel:+10000000000">
                                <div className="ml-3 bold mr-0">
                                    +1 0000000000 - <span className="country">US</span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <div className="bg-primary py-0" style={{ height: "5px", width: "100vw", zIndex: 1000 }}></div>
            </div>
            <div className="desktop" style={{ position: "fixed", bottom: 0, left: 0, width: "100%", zIndex: 9999 }}>
                <div className="bg-primary py-0" style={{ height: "5px", width: "100vw", zIndex: 1000 }}></div>
                <div style={{ height: "50px", background: "#f6faff" }}>
                    <div className="d-flex container justify-content-between align-items-center" style={{ height: "100%", fontSize: "14px" }}>
                        <div className="tophead__wrapper d-flex w-100">
                            <div className="tophead__links show-desktop w-100 justify-content-around">
                                <a href="https://join.skype.com/invite/uX1riqch60Ok" title="Join Skype" target="_blank" rel="noopener noreferrer">
                                    <img src="../images/icons/icon-3.svg" height="30px" width="30px" alt="" />
                                </a>
                                <a href="mailto:support@larapush.com" title="Send Email" target="_blank" rel="noopener noreferrer">
                                    <img src="../images/icons/icon-5.svg" height="30px" width="30px" alt="" />
                                </a>
                                <div data-toggle="modal" data-target="#callNowModal">
                                    <img src="../images/icons/icon-6.svg" height="30px" width="30px" alt="" />
                                </div>
                                <a title="Contact on Whatsapp" href="https://wa.me/919999999999?text=Hi%2C%20I%20am%20interested%20in%20LaraPush." target="_blank" rel="noopener noreferrer">
                                    <img src="../images/icons/icon-1.svg" height="30px" width="30px" alt="" />
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div className="container">
                <div className="d-flex align-items-center header-wrapper px-2 px-md-0 mb-4">
                    <button className="d-xl-none d-lg-none border-0 bg-transparent" aria-label="Open Menu">
                        <svg width="31" height="22" viewBox="0 0 31 22" fill="none" xmlns="http://www.w3.org/2000/svg" alt="toggle links">
                            <line y1="1" x2="31" y2="1" stroke="black" strokeWidth="2"></line>
                            <line y1="11" x2="31" y2="11" stroke="black" strokeWidth="2"></line>
                            <line y1="21" x2="31" y2="21" stroke="black" strokeWidth="2"></line>
                        </svg>
                    </button>
                    <Link to="/" className="d-block my-0 font-weight-normal logo" aria-label="Logo">
                        <img src="images/logo.png" style={{ width: "60%" }} alt="Logo" />
                    </Link>
                    <div className="d-xl-none d-lg-none" data-toggle="modal" data-target="#callNowModal">
                        <svg width="46" height="46" viewBox="0 0 46 46" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="23" cy="23" r="22" fill="white" stroke="black" strokeWidth="2"></circle>
                            <path d="M31.4582 26.4261L27.3018 24.6448C27.1243 24.5691 26.9269 24.5532 26.7395 24.5994C26.5521 24.6455 26.3848 24.7513 26.2627 24.9009L24.4221 27.1497C21.5334 25.7877 19.2086 23.4629 17.8466 20.5742L20.0954 18.7335C20.2452 18.6117 20.3513 18.4444 20.3975 18.2569C20.4437 18.0694 20.4275 17.8719 20.3515 17.6945L18.5702 13.5381C18.4868 13.3468 18.3392 13.1906 18.1529 13.0964C17.9666 13.0022 17.7532 12.976 17.5497 13.0223L13.6902 13.9129C13.494 13.9583 13.3189 14.0688 13.1935 14.2264C13.0682 14.384 13 14.5795 13 14.7809C13 24.2997 20.7152 32 30.219 32C30.4205 32.0001 30.6161 31.9319 30.7738 31.8066C30.9315 31.6812 31.0421 31.5061 31.0874 31.3098L31.9781 27.4503C32.024 27.2458 31.9973 27.0316 31.9024 26.8447C31.8075 26.6577 31.6504 26.5097 31.4582 26.4261Z" fill="#233348"></path>
                        </svg>
                    </div>
                    <nav className="my-2 my-md-0 links d-none d-xl-block d-lg-block" itemType="https://schema.org/SiteNavigationElement" itemScope>
                        <div className="desktop">
                            <Link to="/" className="font-weight-bold">Login</Link>&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;
                            <Link to="/" className="font-weight-bold">Signup</Link>
                        </div>
                    </nav>
                </div>
            </div>


            

      <div className="container position-relative h-100">
        <div className="row">
          <div className="col-md-6">
            <div className="left-box">
              <h2 className="hero-title text-center">
                Say <span className="text-red font-weight-bold">‘NO’</span> to<br />
                <span className="text-red font-weight-bold">MONTHLY EXPENSES</span><br />
                For Sending Push Notifications
              </h2>
              <div className="text-center mt-4 px-4" style={{ color: 'var(--text-extra-light)', maxWidth: '620px' }}>
                Technical Pariwar is a self-hosted push notification panel that comes with a one-time cost and lets you add unlimited domains, collect unlimited subscribers and send unlimited campaigns for unlimited period of time.
              </div>
              <div className="mt-4 mb-5 hero-button text-center">
                <button className="button-primary mt-2" data-testid="landing_book_demo" data-toggle="modal" data-target="#demoModal">View Demo Right Away!</button>
              </div>
            </div>
          </div>
          <div className="col-md-6 d-flex justify-content-center" style={{ height: '550px' }}>
            <div style={{ width: '350px' }}>
              <div className="hero-images position-relative">
                <img src="../images/iphone.webp" className="position-absolute iphone" alt="Hero Image" width={350} height={700} />
                <div className="position-absolute truesignal">
                  <div className="notification">
                    <div className="icon-cover">
                      <img src="../images/truesignal.svg" className="icon" alt="alt-logo-truesignal" width={50} height={50} />
                    </div>
                    <div className="app-name-cover">
                      <div className="app-name">TRUESIGNAL</div>
                    </div>
                    <div className="last-seen-cover">
                      <div className="last-seen">30 min ago</div>
                    </div>
                    <div className="title-cover">
                      <div className="title">Push Notification Monthly Bill !!</div>
                    </div>
                    <div className="description-cover">
                      <div className="description">
                        Hey Dave, Your monthly TrueSignal payment is pending!
                      </div>
                    </div>
                  </div>
                </div>
                <div className="position-absolute larapush-notification">
                  <div className="notification">
                    {/* <div className="icon-cover">
                      <img src="../images/Lara Push Final for svg-06.svg" className="icon" alt="icon" width={50} height={50} />
                    </div> */}
                    <div className="app-name-cover">
                      <div className="app-name">Technical Pariwar</div>
                    </div>
                    <div className="last-seen-cover">
                      <div className="last-seen">10 min ago</div>
                    </div>
                    <div className="title-cover">
                      <div className="title">Technical Pariwar Purchase Successful 🎉</div>
                    </div>
                    <div className="description-cover">
                      <div className="description">
                        Congratulations!! You no-longer have to pay monthly bill.
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div className="hero-element">
          <img src="../images/top-element.svg" alt="design-element" height={100} width={100} loading="lazy" />
        </div>
      </div>
      <div className="container mt-7 does-really">
        <div className="row">
          <div className="col-12 text-center">
            <h2>What, Why &amp; How?</h2>
            <div className="saperator"></div>
            <div className="mt-4 px-3 why-desc phone" style={{ color: 'var(--text-extra-light)', margin: 'auto', maxWidth: '100%' }}>
              We are a team of bloggers who were frustrated by the huge recurring fees charged by SaaS brands.<br />
              We were getting charged hundreds and sometimes thousands of dollars every month.<br />
              So, we came up with a solution to solve this problem by creating a self hosted push notification panel, Technical Pariwar.
            </div>
            <div className="mt-5 px-3 desktop" style={{ color: '#000', margin: 'auto', maxWidth: '100%', textAlign: 'left' }}>
              🌀 We are a team of bloggers who were frustrated by the huge recurring fees charged by SaaS brands.<br /><br />
              🌀 We were getting charged hundreds and sometimes thousands of dollars every month.<br /><br />
              🌀 So, we came up with a solution to solve this problem by creating a self hosted push notification panel, Technical Pariwar.
            </div>
            <div className="top-element">
              <img src="../images/top-element.svg" alt="design-element" height={100} width={100} loading="lazy" />
            </div>
            <div className="row mt-5 my-md-5" id="big-video">
              <div className="col-12 position-relative">
                <div className="box-video" style={{ background: '#d8e9fe', maxWidth: '100%', width: '800px', border: '15px solid #d8e9fe', borderRadius: '15px', zIndex: '998' }}>
                  <div className="bg-video" style={{ backgroundImage: 'url(https://larapush.com/assets/images/video-image.webp)' }}>
                    <div className="bt-play"></div>
                  </div>
                  <div className="video-container" id="video-container"></div>
                </div>
              </div>
            </div>
            <div className="row mt-5 my-md-5" id="key-things">
              <div className="col-md-6" style={{ display: 'flex', alignContent: 'center', alignItems: 'center', flexDirection: 'row-reverse' }}>
                <img src="../images/key-things.png" style={{ maxWidth: '100%' }} height={221} width={380} alt="Key things you should know" />
              </div>
              <div className="col-md-6 text-left pl-3 pl-md-5" style={{ fontSize: '20px' }}>
                <div className="my-5 my-md-4 font-weight-bold">
                  <div className="my-3">🌐 Register Unlimited domains</div>
                  <div className="my-3">👥 Collect Unlimited Subscriptions</div>
                  <div className="my-3">🍿 Send Unlimited Notifications</div>
                  <div className="my-3">♾️ For as long as you want</div>
                  <div className="my-3">💵 By just paying a One-time Fee</div>
                </div>
              </div>
            </div>
            </div>
            </div>
            </div>



            <div className={`row`}>
     
      <button className="button-primary" data-toggle="modal" data-target="#demoModal">
        View Demo Right Away!
      </button>
    </div>
            



            
        </>
    );
}

export default Home;
