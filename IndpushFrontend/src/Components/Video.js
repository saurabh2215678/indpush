import React from "react";
import "./Video.css";



const Video = () =>{
    return (
        <section className="pt-0">
            <div className="container">
                <div className="text-center">
                    <h2>What, Why &amp; How?</h2>
                    <div className="saperator"></div>
                    <div className="mt-4 px-3 why-desc phone">We are a team of bloggers who were frustrated by the huge recurring fees charged by SaaS brands.<br />
                        We were getting charged hundreds and sometimes thousands of dollars every month.<br />So, we came up with a solution to solve this problem by creating a self hosted push notification panel, Larapush.
                    </div>
                    <div className="w_800">
                        <div className="box_video mt-5">
                            <div className="bg-video">
                            <iframe width="100%" height="425" src="https://www.youtube.com/embed/0B59H1XqOm8?si=TBoYXjYc-ukbGUH2" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>                        </div>
                        </div>
                    </div>
                </div>

                <div className="w_800">
                    <div className="row mt-5 my-md-5" id="key-things">
                        <div className="col-md-6" >
                            <img src="images/key-things.png" height="221px" width="380px" alt="Key things you should know" />
                        </div>
                        <div className="col-md-6 text-left ps-3 ps-md-5">
                            <div className="my-5 my-md-4 font-weight-bold">
                            <div className="my-3">🌐 Register Unlimited domains</div>
                            <div className="my-3">👥 Collect Unlimited Subscriptions</div>
                            <div className="my-3">🍿 Send Unlimited Notifications</div>
                            <div className="my-3">♾️ For as long as you want</div>
                            <div className="my-3">💵 By just paying a One-time Fee</div>
                            </div>
                        </div>
                    </div>

                    <div className="mt-4 mb-5 hero-button text-center">
                        <button className="button-primary mt-2">View Demo Right Away!</button>
                    </div>
                </div>
            </div>
        </section>
    )
}

export default Video;