import React from "react";
import "./Banner.css";

const Banner = () => {
  return (
    <section className="position-relative">
      <div className="container">
      <div class="hero-element">
        <img loading="lazy" src="/images/top-element.svg" alt="design-element" height="100px" width="100px"/>
      </div>
        <div className="row">
          <div className="col-md-6">
            <div className="left-box">
              <h2 className="hero-title text-center">
                Say <span className="text-red font-weight-bold">‘NO’</span> to<br />
                <span className="text-red font-weight-bold">MONTHLY EXPENSES</span><br />
                For Sending Push Notifications
              </h2>
              <div className="text-center mt-4 px-4">LaraPush is a self-hosted push notification panel that comes with a one-time cost and lets you add unlimited domains, collect unlimited subscribers and send unlimited campaigns for unlimited period of time.</div>
              <div className="mt-4 mb-5 hero-button text-center">
                <button className="button-primary mt-2">View Demo Right Away!</button>
              </div>
            </div>
          </div>

          <div className="col-md-6 d-flex justify-content-center ht_550">
            <div className="w_350">
              <div className="hero-images position-relative">
                <img src="https://larapush.com/assets/iphone.webp" className="position-absolute iphone" alt="Hero Image" />

                <div className="position-absolute truesignal">
                  <div className="notification">
                    <div className="icon-cover">
                      <img src="https://larapush.com/assets/truesignal.svg" className="icon" alt="alt-logo-truesignal" />
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
                    <div className="icon-cover">
                      <img src="https://larapush.com/assets//images/logo/SVG/Lara Push Final for svg-06.svg" className="icon" alt="icon" />
                    </div>
                    <div className="app-name-cover">
                      <div className="app-name">LARAPUSH</div>
                    </div>
                    <div className="last-seen-cover">
                      <div className="last-seen">10 min ago</div>
                    </div>
                    <div className="title-cover">
                      <div className="title">LaraPush Purchase Successful 🎉</div>
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
      </div>
    </section>
  )
}
export default Banner;