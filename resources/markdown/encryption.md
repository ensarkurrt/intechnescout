# Welcome to Intechne Scout Encryption Document

**Hello everyone!** This document has been prepared to **explain** how your notes about teams are **encrypted**. For your questions and suggestions, you can **contact us** at info@intechnescout.com.

# End-to-End Encryption

All your inspection data in the system is **encrypted**. This encryption may be called "**[End-to-End Encryption](https://en.wikipedia.org/wiki/End-to-end_encryption)**", albeit partially.

**End-to-end encryption** occurs as a result of encryption given by means of "**KEYs**", which consist of random letters and characters generated between the party from which the data will be **read** and the two parties **producing** the data. The reason why "KEY" is used in this encryption is that some blocks in the encryption algorithm **change** according to the keys given during encryption.

**For Example**;
>The text of "**Hi Everyone**";
>"**am1oSmRLMCtvemhmeE5vYlJkL1M0QT09**" password as a result of encryption with "**hello123**" KEY,
> As a result of encrypting with "**hello123**", the password "**WTRNTm9YcVlHclArVGp3NXkrSFM1UT09**" is created.

We use end-to-end encryption in our system, albeit partially. So why do we say **partial**? Because we do not **create** a key on the device in our system. You **determine** the keys that will read your data and ensure that your data is **encrypted**.

We ask you to enter a "**Salt Key**" when registering and Login. You can be sure that this key is **not stored anywhere** in our system. The keys you enter during login and registration are stored in your browser's **local** "[**SESSION**](https://en.wikipedia.org/wiki/Session_(computer_science))" data. And this data cannot be accessed from **anywhere** other than your browser. In short, no one will know the KEY you have set, except you. So **no one** can read your data.

**ATTENTION!** You learn that you know your records and our KEY question over and over when you log in. But you will start with any data record. You can **only** transmit data with a KEY when **creating** the data. 😀

To make sure your data is encrypted, we've open sourced the project's code at [**GitHub**](https://github.com/ensarkurrt/intechnescout).

Have a nice day!
